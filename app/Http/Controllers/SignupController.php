<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activiteit;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'activiteiten_id' => 'required|exists:activiteiten,id',
        ]);
        
        $now = now();
        Auth::user()->activiteiten()->attach($request->activiteiten_id, ['created_at' => $now, 'updated_at' => $now]);

        return response()->json(['message' => 'You have signed up for the event successfully.']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'activiteiten_id' => 'required|exists:activiteiten,id',
        ]);
        Auth::user()->activiteiten()->detach($request->activiteiten_id);

        return response()->json(['message' => 'You have signed out of the event successfully.']);
    }

    public function check(Request $request)
    {
        $request->validate([
            'activiteiten_id' => 'required|exists:activiteiten,id',
        ]);

        $isSignedUp = Auth::user()->activiteiten()->where('activiteiten.id', $request->activiteiten_id)->exists();
        return response()->json(['isSignedUp' => $isSignedUp]);
    }

    public function getUserEvents()
    {
        $deelnemend = Auth::user()->activiteiten()->get();
        return view('schedule.checksignups', ['deelnemend' => $deelnemend]);
    }
}
