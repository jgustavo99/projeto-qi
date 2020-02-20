@extends('adminlte::page')

@section('title', 'Visualizar Entidade')

@section('content_header')
    <h1>Visualizar Entidade</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body">
                <p><b>ID:</b> {{ $entity->id }}</p>
                <p><b>@if ($entity->document_type == 1) CPF @else CNPJ @endif:</b> {{ $entity->document }}</p>
                <p><b>@if ($entity->document_type == 1) Nome Completo @else Razão Social @endif:</b> {{ $entity->corporate_name }}</p>
                <p><b>Nome de Exibição:</b> {{ $entity->name }}</p>
                <p><b>E-mail de Login:</b> {{ $entity->user->email }}</p>
                <p><b>Imagem:</b> <a target="_blank" href="{{ asset('uploads/' . $entity->image) }}">Visualizar</a></p>
                <p><b>Telefone:</b> {{ $entity->phone }}</p>
                <p><b>Endereço:</b> {{ $entity->address }}</p>
                <p><b>Bairro:</b> {{ $entity->neighborhood }}</p>
                <p><b>CEP:</b> {{ $entity->cep }}</p>
                <p><b>Cidade/Estado:</b> {{ $entity->city->name }} / {{ $entity->city->state->abbr }}</p>
                <p><b>Criado em:</b> {{ $entity->created_at->format('d/m/Y H:i:s') }}</p>
                <p><b>Atualizado em:</b> {{ $entity->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>

        <h3>Campanhas</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Valor meta</th>
                        <th>Valor arrecadado</th>
                        <th>Status</th>
                        <th>Realizada em</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $campaigns = $entity->campaigns()->orderBy('created_at', 'DESC')->paginate(10);
                    ?>
                    @if ($campaigns->count() == 0)
                        <tr>
                            <td colspan="5" style="text-align: center">
                                Nenhum registro encontrado
                            </td>
                        </tr>
                    @else
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign->title }}</td>
                                <td>R$ {{ number_format($campaign->amount_goal, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($campaign->total_donated(), 2, ',', '.') }}</td>
                                <td>
                                    @if ($campaign->status == 1)
                                        <span class="badge badge-success">ativa</span>
                                    @else
                                        <span class="badge badge-danger">cancelada</span>
                                    @endif
                                </td>
                                <td>{{ $campaign->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                {!! $campaigns->render() !!}
            </div>
        </div>
    </div>
</div>
@stop
