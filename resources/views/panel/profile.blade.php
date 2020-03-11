@extends('layouts.app')

@section('title', 'App - Meus Dados')

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
                    <h2 class="heading5"><span class="maintext"> Meus Dados</span></h2>

                    <div class="box">
                    @include('layouts.alerts')

                    <form method="post" action="{{ route('profile') }}" class="fv-form fv-form-bootstrap ajax-put-upload" autocomplete="off" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if (!$user->is_entity)
                            <div class="form-group">
                                <label class="control-label">Nome Completo</label>
                                <div class="controls">
                                    <input type="text" class="form-control login-input" name="name" value="{{ $user->name }}" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <input type="email" class="form-control login-input" name="email" value="{{ $user->email }}" required="">
                            </div>

                            <div class="form-group">
                                <label class="control-label">CPF</label>
                                <input type="text" class="form-control login-input" name="cpf" value="{{ $user->document }}" disabled="disabled">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Telefone</label>
                                <input type="text" class="form-control login-input" name="phone" value="{{ $user->phone }}" required="">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
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
                                        <select class="form-control" name="city_id" required="required" id="city_id" data-selected="{{ $user->city->id }}">
                                            <option value="">Selecione um estado...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Nova Senha</label>
                                <input type="password" class="form-control login-input" name="password" placeholder="Para alterar digite sua nova senha">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Confirmar Senha</label>
                                <input type="password" class="form-control login-input" name="password_confirmation" placeholder="Para alterar digite novamente sua nova senha">
                            </div>

                            <div class="form-actions btns mt10">
                                <input type="submit" name="enviarbtn" class="btn btn-orange" value="Salvar">
                            </div>
                    @else
                            <div class="form-group">
                                <label class="control-label">Tipo de Pessoa</label>
                                <div class="controls">
                                    <select class="form-control" disabled="disabled">
                                        <option value="">Selecione...</option>
                                        <option value="2" @if ($user->entity->document_type == 2) selected @endif>Pessoa Jurídica</option>
                                        <option value="1" @if ($user->entity->document_type == 1) selected @endif>Pessoa Física</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label control-document-name">@if ($user->entity->document_type == 2) CNPJ @else CPF @endif</label>
                                <div class="controls">
                                    <input type="text" value="{{ $user->entity->document }}" disabled="disabled" class="span3 login-input form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label control-document-name">@if ($user->entity->document_type == 2) Razão Social @else Nome Completo @endif</label>
                                <div class="controls">
                                    <input type="text" value="{{ $user->entity->corporate_name }}" disabled="disabled" class="span3 login-input form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label control-document-name">Nome de Exibição</label>
                                <div class="controls">
                                    <input type="text" value="{{ $user->entity->name }}" name="name" class="span3 login-input form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Atualizar Imagem</label>
                                <div class="controls" style="margin-bottom: 10px;">
                                    <input type="file" name="image" class="custom-file-input" accept="image/*" id="inputGroupFile01">
                                </div>
                                <a class="fancybox" style="color:#00bcd4 !important;font-size:14px;" rel="gallery" href="{{ url('uploads/'.$user->entity->image) }}">Visualizar imagem atual</a>
                            </div>

                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <div class="controls">
                                    <input type="text" name="email" value="{{ $user->email }}" class="span3 login-input form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Telefone</label>
                                <div class="controls">
                                    <input type="text" name="phone" value="{{ $user->entity->phone }}" class="span3 login-input form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Endereço</label>
                                        <div class="controls">
                                            <input type="text" name="address" value="{{ $user->entity->address }}" class="span3 login-input form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Bairro</label>
                                        <div class="controls">
                                            <input type="text" name="neighborhood" value="{{ $user->entity->neighborhood }}" class="span3 login-input form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">CEP</label>
                                        <div class="controls">
                                            <input type="text" name="cep" value="{{ $user->entity->cep }}" class="span3 login-input form-control" required>
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
                                        <select class="form-control" name="city_id" required="required" id="city_id" data-selected="{{ $user->entity->city->id }}">
                                            <option value="">Selecione um estado...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Descrição de pagamento para doações</label>
                                <textarea class="form-control" rows="3" name="description_payment">{!! $user->entity->description_payment !!}</textarea>
                                <label class="custom-file-label" for="inputGroupFile01" style="margin-top:10px;">Será exibido na página de confirmação de doação para o usuário.</label>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Nova Senha</label>
                                <input type="password" class="form-control login-input" name="password" placeholder="Para alterar digite sua nova senha">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Confirmar Senha</label>
                                <input type="password" class="form-control login-input" name="password_confirmation" placeholder="Para alterar digite novamente sua nova senha">
                            </div>

                            <div class="form-actions btns mt10">
                                <input type="submit" name="enviarbtn" class="btn btn-orange" value="Salvar">
                            </div>
                    @endif
                    </form>
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
        $(".fancybox").fancybox();
        $('[name="phone"]').mask('(00) 0000-00009');
        $('[name="cep"]').mask('00000-000');

        $("#uf option[value={{ !$user->is_entity ? $user->city->state->abbr : $user->entity->city->state->abbr  }}]").attr('selected','selected').change();

        change_city("{{ !$user->is_entity ? $user->city->state->abbr : $user->entity->city->state->abbr }}", "{{ !$user->is_entity ?$user->city->id : $user->entity->city->id }}");

        $('[name="uf"]').on('change', function() {
            if (this.value == '') {
                $('[name="city_id"]').empty().append('<option value="">Selecione um estado...</option>');
            } else {
                change_city(this.value, '');
            }
        });

        function change_city(value, selected)
        {
            if (selected != '') {
                $.get("{{ url('cities/') }}/" + value, null, function (json) {
                    $('[name="city_id"]').empty().append('<option value="">Selecione...</option>');
                    $.each(json, function (key, value) {
                        if (value.id == selected) {
                            $('[name="city_id"]').append('<option value="' + value.id + '" selected>' + value.name + '</option>');
                            $('[name="city_id"] option[value='+selected+']').attr('selected','selected').change();
                        } else {
                            $('[name="city_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                        }
                    });

                }, 'json');
            } else {
                $.get("{{ url('cities/') }}/" + value, null, function (json) {
                    $('[name="city_id"]').empty().append('<option value="">Selecione...</option>');
                    $.each(json, function (key, value) {
                        $('[name="city_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                }, 'json');
            }
        }
    </script>
@endsection
