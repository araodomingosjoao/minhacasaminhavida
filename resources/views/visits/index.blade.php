@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Lista de visitas</h4>
                    <a href="{{ route('visits.new') }}" type="button" class="btn btn-primary px-2 py-1">
                        <i class="bi bi-plus"></i>
                        Cadastrar visita
                    </a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Corretor</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Imóvel</th>
                            <th scope="col">Data</th>
                            <th scope="col">Tipo</th>                  
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($visits as $visit)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $visit->broker->name }}</td>
                                    <td>{{ $visit->client?->name }}</td>
                                    <td>{{ $visit->propertie->title }}</td>
                                    <td>{{ $visit->date }}</td>
                                    <td>{{ $visit->type }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('visits.edit', $visit->id) }}" type="button" class="btn btn-info px-2 py-1">
                                                <i class="bi bi-pencil-square p-0"></i>
                                            </a>
                                            @if ($visit->id !== auth()->id())
                                                <form class="mx-1" action="{{ route('visits.delete', $visit->id) }}" method="POST">
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
