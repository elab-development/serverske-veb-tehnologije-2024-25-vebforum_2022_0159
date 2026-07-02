<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        //API EMAIL VALIDATION PROVERA

        $response = Http::get('https://emailreputation.abstractapi.com/v1/', [
            'api_key' => config('services.abstract.api_key'),
            'email' => $data['email'],
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Email reputation service is unavailable.'
            ], 503);
        }

        $emailData = $response->json();

        if (
            ($emailData['email_deliverability']['status'] ?? null) !== 'deliverable' ||
            ($emailData['email_quality']['is_disposable'] ?? false) === true ||
            ($emailData['email_quality']['is_username_suspicious'] ?? false) === true ||
            ($emailData['email_risk']['address_risk_status'] ?? null) === 'high' ||
            ($emailData['email_risk']['domain_risk_status'] ?? null) === 'high'
        ) {
            return response()->json([
                'message' => 'This email address cannot be used for registration.'
            ], 422);
        }

        $user = User::create([
            ...$data,
            'role' => 'user',
        ]);

        $token = $user->createToken('forum-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('forum-token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully.',
        ]);
    }
}
