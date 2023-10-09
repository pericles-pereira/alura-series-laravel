<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json('Unauthorized', 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('token', ['is_admin']);

        return response()->json($token->plainTextToken);
    }
}
