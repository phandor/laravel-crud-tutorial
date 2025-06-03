<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->guard()->attempt([
            'name' => $incomingFields['loginname'],
            'password' => $incomingFields['loginpassword']
        ])) 
        {
            $request->session()->regenerate();

        }

        return redirect('/');
    }

    public function logout(){
        auth()->guard()->logout();
        return redirect('/');
    }

    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:15', Rule::unique('users', 'name')],
            'email' => ['required', 'email', ],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        auth()->guard()->login($user);
        return redirect('/');
    }
}
