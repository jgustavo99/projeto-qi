@extends('layouts.app')

@section('title', 'App - Campanhas')

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
                    <h2 class="heading5"><span class="maintext"> Minhas Campanhas</span> <a href="{{ route('campaigns.create') }}" class="btn btn-orange">Criar campanha</a></h2>

                    <div class="box">
                        @include('layouts.alerts')

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Sucesso</th>
                                    <th>Status</th>
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
                                            <td><a href="{{ route('campaign.show', $campaign->slug) }}" title="Abrir campanha">{{ $campaign->title }}</a></td>
                                            <td>{{ round($campaign->goal_percentage()) }}%</td>
                                            <td>
                                                @if ($campaign->status == 1)
                                                    <span class="label label-success">ativa</span>
                                                @else
                                                    <span class="label label-danger">encerrada</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('campaigns.show', [$campaign->id]) }}" class="btn btn-orange">Gerenciar</a>

                                                @if ($campaign->status == 1)
                                                    <a href="{{ route('campaigns.edit', [$campaign->id]) }}" class="btn btn-orange">Editar</a>
                                                @endif
                                            </td>
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
    </div>

    <style>
        .fv-form .form-group {
            padding-bottom:10px;
        }
    </style>
@endsection

@section('page-js')
    <script>

    </script>
@endsection
