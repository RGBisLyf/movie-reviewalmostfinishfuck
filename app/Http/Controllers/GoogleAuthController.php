<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
            $user = Socialite::driver('google')->user();

            $findUser = User::where('google_id', $user->getId())->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => encrypt(''),
                    'google_id' => $user->getId()
                ]);
                $newUser->save();
                Auth::login($newUser);
            }
            return redirect('/');

    }
}
