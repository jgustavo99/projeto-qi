@extends('layouts.app')

@section('title', 'App - Painel')

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
                    <h2 class="heading5"><span class="maintext"> Bem-vindo!</span></h2>
                    @if (!auth()->user()->is_entity)
                        <ul class="state clearfix">
                            <li><i class="fa fa-handshake-o"></i>
                                <br>
                                <div class="text">Doações confirmadas : <span style="color:#00bcd4 !important">{{ $data['confirmed_donations'] }}</span></div>
                            </li>
                            <li><i class="fa fa-handshake-o"></i>
                                <br>
                                <div class="text">Doações pendentes : <span style="color:#00bcd4 !important">{{ $data['pending_donations'] }}</span></div>
                            </li>
                        </ul>
                    @else
                        <div class="row">
                            <ul class="state clearfix">
                                <li><i class="fa fa-handshake-o"></i>
                                    <br>
                                    <div class="text">Campanhas ativas : <span style="color:#00bcd4 !important">{{ $data['total_campaign'] }}</span></div>
                                </li>
                                <li><i class="fa fa-money"></i>
                                    <br>
                                    <div class="text">Total arrecadado na última campanha : <span style="color:#00bcd4 !important">R$ {{ number_format($data['total'], 2, ',', '.') }}</span></div>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
