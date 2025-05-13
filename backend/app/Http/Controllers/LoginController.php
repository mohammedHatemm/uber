<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginNeedsVerfication;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    //
    public function submit(Request $request)
    {
        //validate phone number
        $request->validate([
            'phone' => 'required|numeric|min:11',
        ]);


        //find or create user model
        $user = User::firstOrCreate([
            'phone' => $request->phone
        ]);
        if (!$user) {
            return response()->json(['massage' => 'could not process a  user with this phone number '], 401);
        }

        //send the user a one-time usding code (otp)
        $user->notify(new LoginNeedsVerfication());

        //return make a responce
        return response()->json(['massage' => 'text massage notification send ']);
    }
}
