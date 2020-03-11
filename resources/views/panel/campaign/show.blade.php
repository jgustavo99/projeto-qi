@extends('layouts.app')

@section('title', 'App - Gerenciar Campanha')

@section('content')
    <div class="mv100 breadcrumb-container-pages" style="margin-bottom: 30px !important; ">
        <div class="container">
            <ol class="breadcrumb-pages">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('home') }}">Painel</a></li>
            </ol>
        </div>
    </div>

    <!-- Content Start -->
    <div class="container container-menu">
        <div class="row">
            <div class="col-md-12">
                <!-- Sidebar Menu -->
                @include('layouts.sidebar')

                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12 mt40column">
                    <h2 class="heading5"><span class="maintext"> Gerenciar Campanha</span>
                        @if ($campaign->status == 1)
                            <a href="{{ route('campaigns.edit', [$campaign->id]) }}" class="btn btn-orange">Editar</a>
                        @endif
                    </h2>

                    <div class="box">
                        @include('layouts.alerts')

                        <ul class="list-group list-group-flush" style="margin-bottom: 40px;">
                            <li class="list-group-item"><b>Título:</b> {{ $campaign->title }}</li>
                            <li class="list-group-item"><b>Arrecadado:</b> R$ {{ number_format($campaign->total_donated(), 2, ',', '.') }}</li>
                            <li class="list-group-item"><b>Meta:</b> R$ {{ number_format($campaign->amount_goal, 2, ',', '.') }}</li>
                            <li class="list-group-item"><b>Data de Vencimento:</b> {{ $campaign->close_at->format('d/m/Y') }}</li>
                            <li class="list-group-item"><b>Status:</b>
                                @if ($campaign->status == 1)
                                    <span class="label label-success">ativa</span>
                                @else
                                    <span class="label label-danger">encerrada</span>
                                @endif</li>
                        </ul>

                        <h2 class="heading5">Doações</h2>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Doador</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if ($donors->count() == 0)
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        Nenhum registro encontrado
                                    </td>
                                </tr>
                            @else
                                @foreach ($donors as $donor)
                                    <tr>
                                        <td>{{ $donor->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $donor->user->name }}</td>
                                        <td>R$ {{ number_format($donor->amount, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($donor->status == 1)
                                                <span class="label label-warning">pendente</span>
                                            @elseif ($donor->status == 2)
                                                <span class="label label-success">confirmada</span>
                                            @else
                                                <span class="label label-danger">cancelada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($donor->status == 1)
                                                <a href="{{ route('campaigns.confirm-donation', [$donor->id]) }}" class="btn btn-orange">Confirmar pagamento</a>
                                                <a href="{{ route('campaigns.cancel-donation', [$donor->id]) }}" class="btn btn-orange">Cancelar pagamento</a>
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
    </div>

    <style>
        .fv-form .form-group {
            padding-bottom:10px;
        }
    </style>
@endsection


@section('page-js')
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'editor1' );

        $(".fancybox").fancybox();

        $('.amount').mask('000.000.000.000.000,00', {reverse: true});
    </script>
@endsection
