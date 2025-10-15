<?php

namespace App\Http\Repository\Auth;

use App\Models\PasswordOtp;
use App\Models\User;
use Carbon\Carbon;

class PasswordOtpRepository
{
    public function create(string $email, string $otp)
    {
        $user = User::where('email', $email)->first(); // LẤY model instance
        if (!$user) {
            return null; 
        }

        $user->otp = $otp;
        $user->otp_expires_at  = now()->addMinutes(10);
        $user->save(); 
        return $user;
    }

    public function verify(string $email, string $otp): bool
    {
        $record = User::where('email', $email)
            ->where('otp', $otp)
            ->where('expires_at', '>', now())
            ->first();

        return $record !== null;
    }

    public function deleteAllForEmail(string $email)
    {
        $user = User::where('email', $email)->first();
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
    }
}
