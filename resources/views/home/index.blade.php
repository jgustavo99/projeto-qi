@extends('layouts.app')

@section('title', 'Donate - Faça sua doação em uma das campanhas')

@section('content')
    <section id="searchinner" class="margin-top-site">
        <div class="container" style="margin-top: 30px;padding: 0px !important;">
            <div class="searchcontianer">
                <form class="form-inline" method="GET" action="/">
                    <div class="btn-group">
                        <input type="search" name="termo" placeholder="Título de campanha, entidade..." value="{{ request('termo', '') }}" class="form-control mainserarch">
                        <input type="submit" value="Buscar" class="btn btn-orange tooltip-test mainserarchsubmit" data-original-title="" title="">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div class="container">
        <!--  breadcrumb -->
        <h2 class="h2-home">
            @if (request('termo'))
                Pesquisa
            @else
                Últimas Campanhas
            @endif
        </h2>
        @if (request('termo'))
            <h3 style="text-align: center;">Termo da pesquisa: "{{ request('termo') }}"</h3>
        @endif

        <div class="row mt30">
            <!--  Container -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt40column">
                <!-- Listing-->
                <div class="mt30" style="margin-bottom:40px !important;" id="serchlist">
                    <div class="searchresult grid" style="display: block;">
                        @if ($campaigns->count() == 0)
                            <h3 style="text-align: center;font-weight:600">Nenhuma campanha encontrada</h3>
                        @endif

                        @foreach($campaigns->chunk(3) as $row)
                            <ul class="mt30 clearfix row">
                                @foreach($row as $campaign)
                                <li class="col-sm-4">
                                    <div class="searchgrid"> <a class="thumbnail" href="{{ route('campaign.show', [$campaign->slug]) }}"><img src="{{ asset('uploads/campaigns/' . $campaign->image) }}" alt=""></a>
                                        @if ($campaign->created_at->diffInDays() <= 2)
                                        <div class="latest">Recente</div>
                                        @endif
                                        <div>
                                            <h3><a class="title" style="line-height:30px;" href="{{ route('campaign.show', [$campaign->slug]) }}">{{ $campaign->title }} </a></h3>
                                            <ul class="icondetail">
                                                <li><i class="fa fa-calendar"></i> Publicado em {{ $campaign->created_at->format('d/m/Y') }} </li>
                                                <li><i class="fa fa-money"></i> Arrecadado R$ {{ number_format($campaign->total_donated(), 2, ',', '.') }} </li>
                                                <li><i class="fa fa-user"></i> Postado por {{ $campaign->entity->name }}</li>


                                                <div class="box-progr">
                                                <span>{{ round($campaign->goal_percentage()) }}%</span>
                                                <div class="progress">
                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $campaign->goal_percentage() > 100 ? 100 : $campaign->goal_percentage() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $campaign->goal_percentage() > 100 ? 100 : ($campaign->goal_percentage() == 0 ? 1 : $campaign->goal_percentage()) }}%">

                                                    </div>
                                                </div>
                                                </div>
                                            </ul>
                                        </div>
                                        <div>
                                            <div class="share"> Compartilhe: <a data-original-title="Facebook" class="tooltip-test"><i class="fa fa-facebook"></i></a> <a data-original-title="Twitter" class="tooltip-test"><i class="fa fa-twitter"></i></a> <a data-original-title="Google Plus" class="tooltip-test"><i class="fa fa-google-plus"></i></a> </div>
                                            <a class="btn  contact" href="{{ route('donations.donate', [$campaign->slug]) }}"><i class="fa fa fa-thumbs-o-up"></i> DOAR</a> </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endforeach

                        {!! $campaigns->render() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .pagination {
            margin-top:25px;
        }
    </style>
@endsection
