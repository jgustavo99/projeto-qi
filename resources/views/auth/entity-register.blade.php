@extends('layouts.app')

@section('title', 'Donate - Cadastro de entidade')

@section('content')
    <div class="mv100 breadcrumb-container-pages">
        <div class="container">
            <ol class="breadcrumb-pages">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Cadastro de entidade</li>
            </ol>
        </div>
    </div>

    <!-- Content Start -->
    <div class="container">
        <div class="row minus_mb80 mb10">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <h5 class="heading5">Cadastro de entidade</h5>
                <div class="loginbox">
                    @include('layouts.alerts')
                    <form class="loginform form-vertical" action="{{ route('entity-register') }}" method="post" enctype="multipart/form-data">
                        <fieldset>
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label">Tipo de Pessoa</label>
                                <div class="controls">
                                    <select name="document_type" class="form-control" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="2">Pessoa Jurídica</option>
                                        <option value="1">Pessoa Física</option>
                                    </select>
                                </div>
                            </div>

                            <div style="display:none;" class="box-document">
                                <div class="form-group">
                                    <label class="control-label control-document-name">CPF</label>
                                    <div class="controls">
                                        <input type="text" name="document" class="span3 login-input form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label control-name-doc">Nome Completo</label>
                                <div class="controls">
                                    <input type="text" name="corporate_name" class="span3 login-input form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Nome de Exibição</label>
                                <div class="controls">
                                    <input type="text" name="name" class="span3 login-input form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Imagem</label>
                                <div class="controls">
                                    <input type="file" name="image" lass="custom-file-input" required="required" accept="image/*" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01" style="margin-top:10px;">Imagem que irá ser exibida ao lado do nome de exibição nas campanhas.</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <div class="controls">
                                    <input type="text" name="email" class="span3 login-input form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Telefone</label>
                                <div class="controls">
                                    <input type="text" name="phone" class="span3 login-input form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Endereço</label>
                                        <div class="controls">
                                            <input type="text" name="address" class="span3 login-input form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Bairro</label>
                                        <div class="controls">
                                            <input type="text" name="neighborhood" class="span3 login-input form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">CEP</label>
                                        <div class="controls">
                                            <input type="text" name="cep" class="span3 login-input form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <select class="form-control" name="uf" required="required" id="uf">
                                            <option value="">Selecione...</option>
                                            @foreach ($ufs as $uf)
                                            <option value="{{ $uf->abbr }}">{{ $uf->abbr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Cidade</label>
                                        <select class="form-control" name="city_id" required="required" id="city_id">
                                            <option value="">Selecione um estado...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Senha</label>
                                <div class="controls">
                                    <input type="password" name="password" class="span3 login-input form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Confirmar senha</label>
                                <div class="controls">
                                    <input type="password" name="password_confirmation" class="span3 login-input form-control" required>
                                </div>
                            </div>

                        <!--<a class="azul-site" id="password-recovery" href="{{ (Session::has('advertiser')) ? url('advertiser/recuperar-senha') : url('user/recuperar-senha') }}">Recuperar a Senha</a>--> <br>

                            <div class="btns">
                                <input type="submit" name="enviarbtn" class="btn btn-orange btn-ok" value="Cadastrar">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Content End -->
@endsection

@section('page-js')
    <style>
        .loginbox input, loginbox textarea{
            width:100% !important;
        }
    </style>
    <script>
        $('[name="phone"]').mask('(00) 0000-00009');
        $('[name="cep"]').mask('00000-000');

        $('[name="document_type"]').on('change', function() {
            if (this.value == '') {
                $('.box-document').css('display', 'none');
            } else {
                if (this.value == 1) {
                    $('.box-document').css('display', 'block');

                    $('.control-document-name').text('CPF');
                    $('.control-name-doc').text('Nome Completo');

                    $('[name="document"]').unmask();
                    $('[name="document"]').mask('000.000.000-00', {reverse: true});
                }

                if (this.value == 2) {
                    $('.box-document').css('display', 'block');
                    $('.control-document-name').text('CNPJ');

                    $('.control-name-doc').text('Razão Social');

                    $('[name="document"]').unmask();
                    $('[name="document"]').mask('00.000.000/0000-00', {reverse: true});
                }
            }
        });

        $('[name="uf"]').on('change', function() {
            if (this.value == '') {
                $('[name="city_id"]').empty().append('<option value="">Selecione um estado...</option>');
            } else {
                $.get("{{ url('cities/') }}/" + this.value, null, function (json) {
                    $('[name="city_id"]').empty().append('<option value="">Selecione...</option>');
                    $.each(json, function (key, value) {
                        $('[name="city_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                }, 'json');
            }
        });
    </script>
@endsection
