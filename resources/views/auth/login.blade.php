@extends('layouts.app')

@section('title', 'Donate - Login')

@section('content')
    <div class="mv100 breadcrumb-container-pages">
        <div class="container">
            <ol class="breadcrumb-pages">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Login</li>
            </ol>
        </div>
    </div>

    <!-- Content Start -->
    <div class="container">
        <div class="row minus_mb80 mb10">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h5 class="heading5">Login</h5>
                <div class="loginbox">
                    @include('layouts.alerts')
                    <form class="loginform form-vertical" action="{{ route('login') }}" method="post">
                        <fieldset>

                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <div class="controls">
                                    <input type="text" name="email" class="span3 login-input form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Senha</label>
                                <div class="controls">
                                    <input type="password" name="password" class="span3 login-input form-control" required>
                                </div>
                            </div>

                            <!--<a class="azul-site" id="password-recovery" href="{{ (Session::has('advertiser')) ? url('advertiser/recuperar-senha') : url('user/recuperar-senha') }}">Recuperar a Senha</a>--> <br>

                            <div class="btns">
                                <input type="submit" name="enviarbtn" class="btn btn-orange btn-ok" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="loginbox">
                    <h5 class="heading5"> Criar uma Conta</h5>
                    <p class="minus_mb12">Texto de criação da conta...</p>
                    <!--<ul class="whyus">
                        <li><i class="fa  fa-magic"></i> <span class="direname">Fácil Navegação</span> </li>
                        <li><i class="fa fa-arrow-right"></i> <span class="direname">Acesso Direto</span> </li>
                        <li><i class="fa fa-th"></i> <span class="direname">Favoritar </span> </li>
                        <li><i class="fa fa-search"></i><span class="direname">Busca rápida</span> </li>
                    </ul>-->
                    <br>
                    <a class="btn btn-orange btn-ok" href="{{ route('register') }}">Registrar-se como Doador</a>
                    <a class="btn btn-orange btn-ok" href="{{ route('entity-register') }}">Registrar-se como Entidade</a>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Content End -->

    <style>
        @media only screen and (min-width:769px) {
            footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
@endsection
