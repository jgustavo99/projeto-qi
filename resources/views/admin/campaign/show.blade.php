@extends('adminlte::page')

@section('title', 'Visualizar Campanha')

@section('content_header')
    <h1>Visualizar Campanha</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body">
                <p><b>ID:</b> {{ $campaign->id }}</p>
                <p><b>Título:</b> {{ $campaign->title }}</p>
                <p><b>Link:</b> <a href="{{ route('campaign.show', [$campaign->slug]) }}" target="_blank">{{ route('campaign.show', [$campaign->slug]) }}</a> </p>
                <p><b>Imagem:</b> <a href="{{ asset('uploads/campaigns/' . $campaign->image) }}" target="_blank">Ver imagem</a> </p>
                <p><b>Meta: </b> R$ {{ number_format($campaign->amount_goal, 2, ',', '.') }}</p>
                <p><b>Arrecadado: </b> R$ {{ number_format($campaign->total_donated(), 2, ',', '.') }}</p>
                <p><b>Data de Vencimento: </b> {{ $campaign->close_at->format('d/m/Y') }}</p>
                <p><b>Status: </b>
                    @if ($campaign->status == 1)
                        <span class="badge badge-success">ativa</span>
                    @else
                        <span class="badge badge-danger">encerrada</span>
                    @endif</p>
                <p><b>Criado em:</b> {{ $campaign->created_at->format('d/m/Y H:i:s') }}</p>
                <p><b>Atualizado em:</b> {{ $campaign->updated_at->format('d/m/Y H:i:s') }}</p>
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
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $donors = $campaign->donors()->orderBy('created_at', 'DESC')->paginate(10);
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
                                <td><a href="{{ route('campaigns.show', [$donor->campaign->id]) }}">{{ $donor->campaign->title }}</a></td>
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
                                <td>
                                    @if ($donor->status == 1)
                                        <a href="{{ route('admin.campaigns.confirm-donation', [$donor->id]) }}" class="btn btn-primary">Confirmar pagamento</a>
                                        <a href="{{ route('admin.campaigns.cancel-donation', [$donor->id]) }}" class="btn btn-danger">Cancelar pagamento</a>
                                    @else
                                        -
                                    @endif
                                </td>
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
