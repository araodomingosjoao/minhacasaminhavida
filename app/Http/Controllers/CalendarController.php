<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendars.index');
    }

    public function getEvents(Request $request)
    {
        info($request->all());

        $start = $request->input('start'); 
        $end = $request->input('end');     
        $timezone = $request->input('timezone');

        $visits = Visit::whereBetween('date', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end))])->get();

        $events = [];

        foreach ($visits as $visit) {
            $typeColor = '';

            if ($visit->type == 'Não realizado') {
                $typeColor = 'gray';
            } elseif ($visit->type == 'Agendado') {
                $typeColor = 'blue';
            } elseif ($visit->type == 'Realizado') {
                $typeColor = 'green';
            }

            $events[] = [
                'id' => $visit->id,
                'title' => $visit->type,
                'start' => $visit->date,
                'end' => $visit->date, 
                'backgroundColor' => $typeColor,
            ];
        }

        return response()->json($events);
    }
}