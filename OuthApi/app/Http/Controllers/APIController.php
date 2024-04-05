<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{

    /**
     * This is the login method where you get the user details from Google and save it to the database
     *after saving the user details or authenticating the user, you can
     *generate a token for the user and return it to the user
     */
    public function login(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->userFromToken($request->token);
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail()
            ], [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'picture' => $googleUser->avatar,
                'token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
            ]);

            Auth::login($user);

            //get the auth token to use for subsequent requests

            return response()->json([
                'message' => 'Successfully logged in',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
