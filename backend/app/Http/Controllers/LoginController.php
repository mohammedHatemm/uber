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
        $request->validate([
            'phone' => ['required', 'regex:/^\+?[1-9]\d{1,14}$/'], // تحسين التحقق للصيغة الدولية
            'name' => 'required|string|max:255',
        ]);

        // تنسيق الرقم إذا لم يبدأ بـ +
        $phone = strpos($request->phone, '+') === 0 ? $request->phone : '+20' . $request->phone;

        $user = User::firstOrCreate([
            'phone' => $phone,
            'name' => $request->name,

        ]);

        if (!$user) {
            return response()->json(['message' => 'Could not process a user with this phone number'], 401);
        }

        $user->notify(new LoginNeedsVerfication());

        return response()->json(['message' => 'Text message notification sent']);
    }



    public function verify(Request $request)
    {


        //validate requist

        $request->validate([
            'phone' => 'required|numeric|min:11',
            'login_code' => 'required|numeric|between:111111 , 999999',

        ]);



        //find user

        $user = User::where('phone', $request->phone)->where('login_code', $request->login_code)->first();



        //if he founded return tokeen
        if ($user) {
            $user->update([
                'login_code' => null
            ]);
            return $user->createToken($request->login_code);
        }


        // if not return massagee

        return response()->json(['massage' => 'invalde verificaton code'], 401);

        //


    }
}
