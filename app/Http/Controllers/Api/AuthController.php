<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return response()->json([
            'success' => true,
            'token'   => $user->createToken('test')->plainTextToken,
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $response = [];
            $response['token'] = $user->createToken('test')->plainTextToken;
            $response['name'] = $user->name;

            return response()->json($response);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Credentials are not valid',
            ]);
        }
    }
}
