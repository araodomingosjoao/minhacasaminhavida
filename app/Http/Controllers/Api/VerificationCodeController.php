<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Models\Client;
use App\Models\EmailVerificationCode;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\VerificationCodeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationCodeController extends Controller
{
    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'integer', 'exists:verification_codes,code']
        ]);

        $code = VerificationCode::firstWhere('code', $request->code);

        if ($code->created_at > now()->addMinute(5)) {
            $code->delete();

            return response()->json([
                'status' => 'error',
                'message' => 'Verification code is expired.'
            ]);
        }

        $user = User::firstWhere('id', $code->user_id);
        
        $user->update(['is_verified' => true]);

        $code->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Email successfully verified.'
        ]);
    }

    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'exists:users,email']
        ]);

        //Validate that the body email matches that of the authenticated user
        if(!(Auth::user()->email === $request->input('email') )){
            return response()->json([
                'status' => 'error',
                'message' => 'Email does not match that of authenticated user.'
            ]); 
        }

        //Validating that email is already verified
        if((Auth::user('client')->is_verified_email === 'verified')){
            return response()->json([
                'status' => 'error',
                'message' => 'Email is already verified.'
            ]); 
        }

        $email = VerificationCode::firstWhere('email', $request->input('email'));
        
        //Validating that you have an active verification code
        if ($email && Carbon::now()->diffInMinutes($email->created_at) < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only receive another verification code after 5 minutes.'
            ]);
        }

        // If the 5 minutes have passed delete the old code
        if ($email && Carbon::now()->diffInMinutes($email->created_at) > 1) {
            $email->delete();
        }

        // Generates and saves new code
        $code = VerificationCodeService::save('email_verification_codes', $request);

        //sends the email
        dispatch(new SendEmailJob($request->input('email'), $code));

        return response()->json([
            'status' => 'success',
            'message' => 'Verification code successfully resent.'
        ]);
    }
}