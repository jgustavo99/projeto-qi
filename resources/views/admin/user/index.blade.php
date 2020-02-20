@extends('adminlte::page')

@section('title', 'Usuários doadores')

@section('content_header')
    <h1>Usuários doadores</h1>
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
                        <th>E-mail</th>
                        <th>Cadastrado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if ($users->count() == 0)
                        <tr>
                            <td colspan="5" style="text-align: center">
                                Nenhum registro encontrado
                            </td>
                        </tr>
                    @else
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary">Editar</a>
                                    <a href="{{ route('users.destroy', [$user->id]) }}" class="btn btn-danger">Remover</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        {!! $users->render() !!}

        <style>
            tr td {
                vertical-align: middle !important;
                padding-top: 8px !important;
            }
        </style>
    </div>
</div>
@stop
