<?php
namespace App\Services;

use DateTime;
use Illuminate\Support\Facades\DB;

class VerificationCodeService 
{
    public static function generate() 
    {
        $code = random_int(pow(10, 5-1), pow(10, 5)-1);

        if (DB::table('verification_codes')->where('code', $code)->exists()) {
            $class = new self();
            $class->generate();
        }

        return $code;
    }

    public static function save($user) 
    {
        $class = new self();
        $code = $class->generate();
 
        DB::table('verification_codes')->insert([
            'user_id' => $user->id, 
            'code' => $code, 
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        return $code;
    }
}
