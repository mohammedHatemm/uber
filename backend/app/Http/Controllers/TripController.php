<?php

namespace App\Http\Controllers;

use App\Events\TripAccepted;
use App\Events\TripLocationUpdated;
use App\Events\TripStarted;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'origin' => 'required',
            'destination_name' => 'required',
        ]);
        $trip = $request->user()->trips()->create($request->only([
            'origin',
            'destination',
            'destination_name',
        ]));
        return $trip;
    }

    public function show(Request $request, Trip $trip)
    {
        if ($trip->user->id ===  $request->user()->id) {
            return $trip;
        }
        if ($trip->driver && $request->user()->driver) {

            if ($trip->driver->id === $request->driver()->id) {
                return $trip;
            }
        }
        return response()->json(["massage" => "can not find the trip "], 404);
    }
    public function accept(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required',

        ]);
        $trip->update([
            'driver' => $request->user()->id,
            'location' => $request->driver_location,
        ]);
        $trip->load('driver.user');
        TripAccepted::dispatch($trip, $request->user());
        return $trip;
    }
    public function start(Request $request, Trip $trip)
    {
        $trip->update([
            'is_started' => true,
        ]);

        $trip->load('drive.user');
        TripStarted::dispatch($trip, $request->user());
        return $trip;
    }
    public function end(Request $request, Trip $trip)
    {
        $trip->update([
            'is_completed' => true,
        ]);
        $trip->load('driver.user');
        TripStarted::dispatch($trip, $request->user());
        return $trip;
    }
    public function location(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required',
        ]);
        $trip->update([
            'driver_location' => $request->drive_location,
        ]);
        $trip->load('driver.user');
        TripLocationUpdated::dispatch($trip, $request->user());
        return $trip;
    }
}

//  $table->json('destination')->nullable();
//             $table->json('origin')->nullable();
//             $table->string('destination_name')->nullable();
