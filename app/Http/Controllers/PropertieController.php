<?php

namespace App\Http\Controllers;

use App\Models\Propertie;
use App\Models\PropertieImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertieController extends Controller
{
    public function index() {
        $properties = Propertie::all();

        return view('properties.index', compact('properties'));
    }

    public function new() {
        return view('properties.new');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'max:255'], 
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'type' => ['required', 'in:Venda,Aluguel'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        Propertie::create($validated);

        return redirect()->route('properties.index');
    }

    public function edit($id) {
        $propertie = Propertie::findOrFail($id);

        return view('properties.edit', compact('propertie'));
    }

    public function update(Request $request, $id) {
        $propertie = Propertie::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'max:255'], 
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'type' => ['required', 'in:Venda,Aluguel'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $propertie->update($validated);

        return redirect()->route('properties.index');
    }

    public function delete($id) {
        Propertie::findOrFail($id)->delete();

        return redirect()->route('properties.index');
    }

    public function showImages($id)
    {
        $propertie = Propertie::find($id);
        if (!$propertie) {
            return redirect()->route('properties.index')->with('error', 'Imóvel não encontrado');
        }

        $images = $propertie->images; // Acesse a relação de imagens

        return view('properties.images', compact('propertie', 'images'));
    }

    public function uploadImage(Request $request, $id)
    {
        $propertie = Propertie::find($id);
        if (!$propertie) {
            return redirect()->route('properties.index')->with('error', 'Imóvel não encontrado');
        }

        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'images/properties/' . $imageName;
        Storage::disk('public')->put($imagePath, file_get_contents($image));
        
        // Crie a imagem vinculada à propriedade
        $propertie->images()->create(['path' => $imagePath]);

        return redirect()->route('properties.showImages', $propertie->id);
    }

    public function deleteImage($propertie, $image)
    {
        $propertie = Propertie::find($propertie);
        $image = PropertieImage::find($image);

        if (!$propertie || !$image) {
            return redirect()->route('properties.index')->with('error', 'Imóvel ou imagem não encontrados');
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('properties.showImages', $propertie->id);
    }
}
