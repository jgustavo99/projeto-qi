@extends('adminlte::page')

@section('title', 'Entidades')

@section('content_header')
    <h1>Entidades</h1>
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
                        <th>Nome</th>
                        <th>E-mail de Login</th>
                        <th>Cadastrado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if ($entities->count() == 0)
                        <tr>
                            <td colspan="5" style="text-align: center">
                                Nenhum registro encontrado
                            </td>
                        </tr>
                    @else
                        @foreach ($entities as $entity)
                            <tr>
                                <td>{{ $entity->id }}</td>
                                <td><a href="{{ route('entities.show', [$entity->id]) }}">{{ $entity->name }}</a></td>
                                <td>{{ $entity->user->email }}</td>
                                <td>{{ $entity->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('entities.edit', [$entity->id]) }}" class="btn btn-primary">Editar</a>
                                    <a href="{{ route('entities.destroy', [$entity->id]) }}" class="btn btn-danger">Remover</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        {!! $entities->render() !!}

        <style>
            tr td {
                vertical-align: middle !important;
                padding-top: 8px !important;
            }
        </style>
    </div>
</div>
@stop
