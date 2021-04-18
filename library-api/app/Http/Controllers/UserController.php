<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests\UserRegisterRequest;
use Hash;
 

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function register(UserRegisterRequest $request) {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'password'=> Hash::make($request->password)
        ]);
        return response()->json(["message" => "User created successfully!", "code" => 200]);
    }
}
