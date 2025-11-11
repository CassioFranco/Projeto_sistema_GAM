<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function show($id)
    {
        $user = User::with('assets')->findOrFail($id);
        return response()->json($user);
    }

    public function updateLocation(Request $request, $id)
{
    $validated = $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    if ($request->user()->id != $id) {
        return response()->json(['message' => 'Não autorizado'], 403);
    }

    $loc = Location::create([
        'user_id'    => $id,
        'latitude'   => $validated['latitude'],
        'longitude'  => $validated['longitude'],
        'recorded_at'=> now(),
    ]);

    $request->user()->update([
        'latitude'  => $validated['latitude'],
        'longitude' => $validated['longitude'],
    ]);

    return response()->json($loc, 201);
}


    public function history($id)
    {
        $locations = Location::where('user_id',$id)->orderBy('recorded_at','desc')->get();
        return response()->json($locations);
    }
}
