<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request): ProfileResource
    {
        $user = $request->user() ?? $request->user('api');

        if (! $user) {
            abort(404);
        }

        return new ProfileResource($user);
    }
}
