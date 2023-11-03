<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrokerController extends Controller
{
    public function index() {
        $brokers = Broker::all();

        return view('brokers.index', compact('brokers'));
    }

    public function new() {
        return view('brokers.new');
    }

    public function store(Request $request)
    {    
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'whatsapp' => ['required', 'string'],
                'creci' => ['required', 'string'],
                'image' => ['required'],
            ]);
    
    
            // Lidar com o upload da imagem, caso seja fornecida
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'images/brokers/' . $imageName;
    
                // Salvar a imagem no servidor (por padrão, ela será armazenada na pasta "storage/app/public")
                Storage::disk('public')->put($imagePath, file_get_contents($image));
    
                // Atualizar o valor do campo "image" no array validado
                $validated['image'] = $imagePath;
            }
    
            // Criar o registro do corretor
            Broker::create($validated);
    
            return redirect()->route('brokers.index');     
    }



    public function edit($id) {
        $broker = Broker::findOrFail($id);

        return view('brokers.edit', compact('broker'));
    }

    public function update(Request $request, $id) {
        $broker = Broker::findOrFail($id);
    
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:brokers,email,' . $broker->id],
            'whatsapp' => ['required', 'string'], 
            'creci' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        
    
        $broker->update($validated);
    
        return redirect()->route('brokers.index');
    }
       
    public function delete($id) {
        Broker::findOrFail($id)->delete();

        return redirect()->route('brokers.index');
    }
}
