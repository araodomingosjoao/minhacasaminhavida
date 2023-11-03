@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar Visita</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('visits.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="broker_id" class="col-md-4 col-form-label text-md-end">Corretor</label>
                            <div class="col-md-6">
                                <select id="broker_id" name="broker_id" class="form-select select2">
                                    <option value="" disabled selected>Selecione o corretor</option>
                                    @foreach($brokers as $broker)
                                        <option value="{{ $broker->id }}">{{ $broker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                                            
                        <div class="row mb-3">
                            <label for="client_id" class="col-md-4 col-form-label text-md-end">Cliente</label>
                            <div class="col-md-6">
                                <select id="client_id" name="client_id" class="form-select select2">
                                    <option value="" disabled selected>Selecione o cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="propertie_id" class="col-md-4 col-form-label text-md-end">Imóvel</label>
                            <div class="col-md-6">
                                <select id="propertie_id" name="propertie_id" class="form-select select2">
                                    <option value="" disabled selected>Selecione o Imóvel</option>
                                    @foreach($properties as $propertie)
                                        <option value="{{ $propertie->id }}">{{ $propertie->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="date" class="col-md-4 col-form-label text-md-end">Data e Hora</label>
                            <div class="col-md-6">
                                <input type="datetime-local" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">Tipo</label>
                            <div class="col-md-6">
                                <select id="type" name="type" class="form-select" required>
                                    <option value="Agendado">Agendado</option>
                                    <option value="Não agendado">Não agendado</option>
                                    <option value="Realizado">Realizado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                                <a href="{{ route('visits.index') }}" type="submit" class="btn btn-secondary">
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
