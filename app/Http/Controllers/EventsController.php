<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activiteit;

class EventsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'location' => 'required|string',
            'leeftijdsgroep' => 'required|string',
            'hoofdAnimatoren' => 'nullable|string',
            'maxAnimatoren' => 'required|integer',
            'beschikbarePlaatsen' => 'nullable|integer',
            'typeActiviteit' => 'required|integer',
        ]);

        $event = Activiteit::create($data);
        $request->session()->flash('status', 'Activiteit toegevoegd!');
        return redirect()->route('addevent');
    }

    public function getEvents()
    {
        $activiteiten = Activiteit::with('users')->get();

        $events = $activiteiten->map(function ($activiteit) {
        $start = Carbon::parse($activiteit->start_time);
        $end = Carbon::parse($activiteit->end_time)->addDay();
        $hoofdanis = '';
        if ($activiteit->hoofdAnimatoren == null) {
            $hoofdanis = '';
        }
        else
            $hoofdanis = $activiteit->hoofdAnimatoren;
        $color = '';
        switch($activiteit->typeActiviteit) {
            case 0:
                $color = '#FFC1C1';
                break;
            case 1:
                $color = '#FFFF99';
                break;
            case 2:
                $color = '#98FB98';
                break;
            default:
                $color = '#ADD8E6';
                break;
        }
            return [
                'id' => $activiteit->id,
                'title' => $activiteit->name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'start_time' => $start->format('H:i'),
                'end_time' => $end->format('H:i'),
                'location' => $activiteit->location,
                'leeftijdsgroep' => $activiteit->leeftijdsgroep,
                'hoofdAnimatoren' => $hoofdanis,
                'maxAnimatoren' => $activiteit->maxAnimatoren,
                'typeActiviteit' => $activiteit->typeActiviteit,
                'color' => $color,
                'users' => $activiteit->users->pluck('name'),
            ];
        });
        return response()->json($events);
    }
}
