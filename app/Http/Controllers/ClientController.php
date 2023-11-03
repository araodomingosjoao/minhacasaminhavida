<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() {
        $clients = client::all();

        return view('clients.index', compact('clients'));
    }

    public function new() {
        return view('clients.new');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
            'whatsapp' => ['required', 'numeric'],
            'adress' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
        ]);

        Client::create($validated);

        return redirect()->route('clients.index');
    }

    public function edit($id) {
        $client = Client::findOrFail($id);

        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id) {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email,' . $client->id],
            'whatsapp' => ['required', 'numeric', ],
            'adress' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],


        ]);

        $client->update($validated);

        return redirect()->route('clients.index');
    }

    public function delete($id) {
        Client::findOrFail($id)->delete();

        return redirect()->route('clients.index');
    }
}
