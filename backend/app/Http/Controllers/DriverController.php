<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class DriverController extends Controller
{
    //
    public function show(Request $request)
    {
        $user = $request->user();
        $user->load('driver');
        return $user;
    }
    public function update(Request $request)
    {

        $request->validate([
            'year' => 'required|numeric',
            'color' => 'required',
            'make' => 'required',
            'model' => 'required',
            'licance_plate' => 'required',
            'name' => 'required',


        ]);
        $user = $request->user();
        $user->update($request->only('name'));
        $user->driver()->updateOrCreate($request->only([
            'model',
            'make',
            'year',
            'color',
            'licance_plate',

        ]));
        $user->load('driver');
        return $user;
    }
}
