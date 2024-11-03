<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->authenticate();

        $user = User::where('email', $request->input('email'))->first();

        // Generate token after successful authentication
        $token = $user->createToken('auth_token')->plainTextToken;
        // Save token on user
        $user->update(['api_token' => $token]);

        return response()->json(['message' => 'Login successful', 'token' => $token]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
