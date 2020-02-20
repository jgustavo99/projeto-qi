@extends('layouts.app')

@section('title', 'Donate - Minhas Doações')

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
                    <h2 class="heading5"><span class="maintext"> Minhas Doações</span></h2>

                    <div class="box">
                        @include('layouts.alerts')

                        @if(Session::has('donate'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {!! Session::get('donate') !!}
                            </div>
                        @endif

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Campanha</th>
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
                                            <td><a href="{{ route('campaign.show', $donor->campaign->slug) }}" title="Abrir campanha">{{ $donor->campaign->title }}</a></td>
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
                                                    <a style="cursor: pointer;" class="btn btn-orange" data-toggle="modal" data-target="#modalPay{{ $donor->id }}">Pagar</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalPay{{ $donor->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel" style="color:#00bcd4 !important;">Pagamento</h4>
                                                    </div>
                                                    <div class="modal-body" style="font-size:14px !important;">
                                                        <p>Faça o pagamento da doação conforme as instruções da entidade. Após efetuar o pagamento, enviar o comprovante para a entidade para que assim sua doação seja confirmada em nosso sistema.</p>
                                                        <b>Instruções da entidade:</b>
                                                        <p style="margin-top:5px;">
                                                            @if (empty($donor->campaign->entity->description_payment))
                                                                -
                                                            @else
                                                                {!! nl2br(e($donor->campaign->entity->description_payment)) !!}
                                                            @endif
                                                        </p>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <script>

    </script>
@endsection
