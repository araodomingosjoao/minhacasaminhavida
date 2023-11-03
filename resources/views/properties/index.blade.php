@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Lista de imóveis</h4>
                    <a href="{{ route('properties.new') }}" type="button" class="btn btn-primary px-2 py-1">
                        <i class="bi bi-plus"></i>
                        Cadastrar Usuário
                    </a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Título</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Latitude</th>
                            <th scope="col">Longitude</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Endereço</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($properties as $propertie)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $propertie->title }}</td>
                                    <td>{{ $propertie->description }}</td>
                                    <td>{{ $propertie->latitude }}</td>
                                    <td>{{ $propertie->longitude }}</td>
                                    <td>{{ $propertie->type }}</td>
                                    <td>{{ $propertie->address }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('properties.edit', $propertie->id) }}" type="button" class="btn btn-info px-2 py-1">
                                                <i class="bi bi-pencil-square p-0"></i>
                                            </a>
                                            <a href="{{ route('properties.showImages', $propertie->id) }}" type="button" class="btn btn-info px-2 py-1">
                                                <i class="bi bi-image p-0"></i>
                                            </a>
                                            @if ($propertie->id !== auth()->id())
                                                <form class="mx-1" action="{{ route('properties.delete', $propertie->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-2 py-1">
                                                        <i class="bi bi-trash p-0"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
