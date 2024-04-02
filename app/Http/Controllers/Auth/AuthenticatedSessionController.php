<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Posts\ReactionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        return response()->json([
            'token' => $user->createToken('Personal Access Token')->accessToken,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'csrf_token' => csrf_token(),
            'reactions' => ReactionEnum::getAvailableReactions(),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $request->user()?->token()?->delete();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
