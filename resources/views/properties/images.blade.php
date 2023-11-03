@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Imagens do Imóvel</h4>
                    <a href="{{ route('properties.index') }}" type="button" class="btn btn-secondary px-2 py-1">
                        Voltar
                    </a>
                </div>
                <div class="card-body">
                    @if ($propertie && $propertie->images && count($propertie->images) > 0)
                        <div class="row">
                            @foreach ($propertie->images as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="Imagem do Imóvel">
                                        <div class="card-body">
                                            <form action="{{ route('properties.deleteImage', ['propertie' => $propertie->id, 'image' => $image->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Ops, não há imagens no seu imóvel.</p>
                    @endif

                    <div class="mt-3">
                        <form action="{{ route('properties.uploadImage', $propertie->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="image" class="form-label">Selecione uma imagem para adicionar:</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Adicionar Imagem</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
