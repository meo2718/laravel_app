<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginWithGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver("google")->redirect();
    }

    // 追加
    public function googleCallback()
    {
        try {
            $user = Socialite::driver("google")->user();
            $finduser = User::where("google_id", $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended("login");
            } else {
                $newUser = User::create([
                    "name" => $user->name,
                    "email" => $user->email,
                    "google_id" => $user->id,
                    "password" => encrypt("qwer1234"),
                ]);

                Auth::login($newUser);

                return redirect()->intended("login");
            }
        } catch (Exception $e) {
            \Log::error($e);
            throw $e->getMessage();
        }
    }
}
