<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function new() {
        return view('users.new');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'whatsapp' => ['required', 'string', 'max:20'], 
            
        ]);
        User::create($validated);

        return to_route('users.index');
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'whatsapp' => ['required', 'string', 'max:20'], 
            
        ]);

        $user->update($validated);

        return to_route('users.index');
    }

    public function delete($id) {
        User::findOrFail($id)->delete();

        return to_route('users.index');
    }
}
