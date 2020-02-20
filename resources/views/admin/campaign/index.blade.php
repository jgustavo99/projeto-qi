@extends('adminlte::page')

@section('title', 'Campanhas')

@section('content_header')
    <h1>Campanhas</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Valor arrecadado</th>
                        <th>Status</th>
                        <th>Cadastrado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if ($campaigns->count() == 0)
                        <tr>
                            <td colspan="5" style="text-align: center">
                                Nenhum registro encontrado
                            </td>
                        </tr>
                    @else
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign->id }}</td>
                                <td><a href="{{ route('admin.campaigns.show', [$campaign->id]) }}">{{ $campaign->title }}</a></td>
                                <td>R$ {{ number_format($campaign->total_donated(), 2, ',', '.') }}</td>
                                <td>
                                    @if ($campaign->status == 1)
                                        <span class="badge badge-success">ativa</span>
                                    @else
                                        <span class="badge badge-danger">encerrada</span>
                                    @endif
                                </td>
                                <td>{{ $campaign->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if ($campaign->status == 1)
                                        <a href="{{ route('admin.campaigns.edit', [$campaign->id]) }}" class="btn btn-primary">Editar</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        {!! $campaigns->render() !!}

        <style>
            tr td {
                vertical-align: middle !important;
                padding-top: 8px !important;
            }
        </style>
    </div>
</div>
@stop
