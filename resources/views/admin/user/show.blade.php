@extends('adminlte::page')

@section('title', 'Visualizar Usuário')

@section('content_header')
    <h1>Visualizar Usuário</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body">
                <p><b>ID:</b> {{ $user->id }}</p>
                <p><b>Nome:</b> {{ $user->name }}</p>
                <p><b>E-mail:</b> {{ $user->email }}</p>
                <p><b>Documento:</b> {{ $user->document }}</p>
                <p><b>Telefone:</b> {{ $user->phone }}</p>
                <p><b>Criado em:</b> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                <p><b>Atualizado em:</b> {{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>

        <h3>Doações</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Campanha</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Realizada em</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $donors = $user->donors()->orderBy('created_at', 'DESC')->paginate(10);
                    ?>
                    @if ($donors->count() == 0)
                        <tr>
                            <td colspan="5" style="text-align: center">
                                Nenhum registro encontrado
                            </td>
                        </tr>
                    @else
                        @foreach ($donors as $donor)
                            <tr>
                                <td><a href="{{ route('admin.campaigns.show', [$donor->campaign->id]) }}">{{ $donor->campaign->title }}</a></td>
                                <td>R$ {{ number_format($donor->amount, 2, ',', '.') }}</td>
                                <td>
                                    @if ($donor->status == 1)
                                        <span class="badge badge-warning">pendente</span>
                                    @elseif ($donor->status == 2)
                                        <span class="badge badge-success">confirmada</span>
                                    @else
                                        <span class="badge badge-danger">cancelada</span>
                                    @endif
                                </td>
                                <td>{{ $donor->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                {!! $donors->render() !!}
            </div>
        </div>
    </div>
</div>
@stop
