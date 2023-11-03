@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Endereço</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.update', $client->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $client->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $client->email }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="whatsapp" class="col-md-4 col-form-label text-md-end">WhatsApp</label>
                            <div class="col-md-6">
                                <input id="whatsapp" type="text" class="form-control" name="whatsapp" required value="{{ $client->whatsapp }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="adress" class="col-md-4 col-form-label text-md-end">Endereço</label>
                            <div class="col-md-6">
                                <input id="adress" type="text" class="form-control" name="adress" required value="{{ $client->adress }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-end">Data de Nascimento</label>
                            <div class="col-md-6">
                                <input id="birthdate" type="date" class="form-control" name="birthdate" required value="{{ $client->birthdate }}">
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
