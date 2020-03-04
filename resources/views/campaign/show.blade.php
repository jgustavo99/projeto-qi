@extends('layouts.app')

@section('title', 'App - Campanha ' . $campaign->title)

@section('content')

    <div class="container mv100" style="margin-top:100px !important;margin-bottom: 40px !important;">
        <h2 class="mt40 title-campaign">{{ $campaign->title }} </h2>

        <div class="row mt40" style="margin-bottom:22px;">
            <!-- Left Image-->
            <div class="col-xl-7 col-lg-7 col-md-12 col-12 col-sm-12">
                <a class="thumbnail" style="border: 0.1px solid #ddd !important;cursor:default !important;margin-bottom:12px !important;">
                    <img src="{{ asset('uploads/campaigns/' . $campaign->image) }}" style="text-align: center;margin:auto;" class="img-responsive"/>
                </a>
                <div class="share" style="font-size:19px;font-weight:600;"> Compartilhe: <a data-original-title="Facebook" class="tooltip-test"><i class="fa fa-facebook"></i></a> <a data-original-title="Twitter" class="tooltip-test"><i class="fa fa-twitter"></i></a> <a data-original-title="Google Plus" class="tooltip-test"><i class="fa fa-google-plus"></i></a> </div>
            </div>
            <!-- Right Details-->
            <div class="col-xl-5 col-lg-5 col-md-12 col-12 col-sm-12 mt40column">
                <div class="clearfix">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $campaign->goal_percentage() > 100 ? 100 : $campaign->goal_percentage() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $campaign->goal_percentage() > 100 ? 100 : ($campaign->goal_percentage() == 0 ? 1 : $campaign->goal_percentage()) }}%">

                        </div>
                    </div>
                    <div class="box">
                        <span style="font-size:16px; font-weight:600;padding-top:0px !important;">Arrecadado</span>
                        <div class="price" style="margin-bottom:20px;color:#00bcd4 !important;font-weight:600;"> <span style="display: block;padding-top:5px;">R$ {{ number_format($campaign->total_donated(), 2, ',', '.') }}</span></div>

                        <p style="font-size:17px;font-weight:600;padding-bottom:0px !important;margin-bottom:5px;">Meta</p>
                        <p style="font-size:17px;font-weight:600;padding-bottom:10px;">R$ {{ number_format($campaign->amount_goal, 2, ',','.') }}</p>

                        <p style="font-size:17px;font-weight:600;padding-bottom:0px !important;margin-bottom:5px;">Apoiadores</p>
                        <p style="font-size:17px;font-weight:600;">{{ $campaign->donors()->where('status', 2)->groupBy('user_id')->get()->count() }}</p>

                        <a href="{{ route('donations.donate', [$campaign->slug]) }}" class="pull-right btn btn-orange btn-lg" style="width:100%;margin-top:5px;margin-bottom:23px;">Doar</a> </div>

                        <div class="box-campaign">
                            <div class="pull-left">
                                <img src="{{ asset('uploads/' . $campaign->entity->image) }}" class="img-circle img-responsive" style="width:60px;">
                            </div>

                            <p style="font-weight:600; font-size:16px; vertical-align: middle !important;display:inline-block;margin-left:12px;margin-top:12px;">{{ $campaign->entity->name }} <br> <span style="font-size:13px !important;display: inline-block;margin-top:5px !important;font-weight:500 !important;">{{ $campaign->entity->city->name }} / {{ $campaign->entity->city->state->abbr }}</span></p>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {!! $campaign->description !!}
            </div>
        </div>
    </div>

    <style>
        .pagination {
            margin-top:25px;
        }
    </style>
@endsection
