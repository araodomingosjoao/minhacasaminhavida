<?php

namespace App\Http\Controllers;

use App\Mail\VisitNotification;
use App\Models\Broker;
use App\Models\Client;
use App\Models\Propertie;
use App\Models\Visit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VisitController extends Controller
{
    public function index() {
        $visits = Visit::all();

        return view('visits.index', compact('visits'));
    }

    public function new() {
        $brokers = Broker::all();
        $clients = Client::all();
        $properties = Propertie::all();

        return view('visits.new', compact('brokers', 'clients', 'properties'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'broker_id' => ['required'], // Substituído de 'broker' para 'broker_id'
            'client_id' => ['required'], // Substituído de 'client' para 'client_id'
            'propertie_id' => ['required'], // Substituído de 'propertie' para 'propertie_id'
            'date' => ['required'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $visit = new Visit();
        $visit->broker_id = $request->input('broker_id'); // Substituído de 'broker' para 'broker_id'
        $visit->client_id = $request->input('client_id'); // Substituído de 'client' para 'client_id'
        $visit->propertie_id = $request->input('propertie_id'); // Substituído de 'propertie' para 'propertie_id'
        
        // Ajuste o formato da data
        $visit->date = date('Y-m-d H:i:s', strtotime($request->input('date')));
        
        $visit->type = $request->input('type');
    
        $visit->save();

        // Envie um e-mail para o cliente, se o cliente existir
        $client = Client::find($visit->client_id); // Substituído de 'client' para 'client_id'

        if ($client) {
            $clientEmail = $client->email;
            Mail::to($clientEmail)->send(new VisitNotification($visit));
        }

        // Envie um e-mail para o corretor, se o corretor existir
        $broker = Broker::find($visit->broker_id); // Substituído de 'broker' para 'broker_id'
        if ($broker) {
            $brokerEmail = $broker->email;
            Mail::to($brokerEmail)->send(new VisitNotification($visit));
        }

        return redirect()->route('visits.index');
    }

    public function edit($id) {
        $visit = Visit::findOrFail($id);
        $brokers = Broker::all();
        $clients = Client::all();
        $properties = Propertie::all();
    
        return view('visits.edit', compact('visit', 'brokers', 'clients', 'properties'));
    }

    public function update(Request $request, $id) {
        // dd($request->method());
        $visit = Visit::findOrFail($id);

        $request->validate([
            'broker_id' => ['required', 'string', 'max:255'], // Substituído de 'broker' para 'broker_id'
            'client_id' => ['required', 'string', 'max:255'], // Substituído de 'client' para 'client_id'
            'propertie_id' => ['required', 'string', 'max:255'], // Substituído de 'propertie' para 'propertie_id'
            'date' => ['required'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $visit->broker_id = $request->input('broker_id'); // Substituído de 'broker' para 'broker_id'
        $visit->client_id = $request->input('client_id'); // Substituído de 'client' para 'client_id'
        $visit->propertie_id = $request->input('propertie_id'); // Substituído de 'propertie' para 'propertie_id'
        
        // Ajuste o formato da data
        $visit->date = date('Y-m-d H:i:s', strtotime($request->input('date')));
        
        $visit->type = $request->input('type');
    
        $visit->save();

        return redirect()->route('visits.index');
    }

    public function delete($id) {
        Visit::findOrFail($id)->delete();

        return redirect()->route('visits.index');
    }
}
