@extends('adminlte::page')

@section('title', 'Editar Entidade')

@section('content_header')
    <h1>Editar Entidade</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('entities.update', [$entity->id]) }}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="control-label">Tipo de Pessoa</label>
                        <div class="controls">
                            <select class="form-control" name="document_type" required>
                                <option value="">Selecione...</option>
                                <option value="2" @if ($entity->document_type == 2) selected @endif>Pessoa Jurídica</option>
                                <option value="1" @if ($entity->document_type == 1) selected @endif>Pessoa Física</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-document">
                        <div class="form-group">
                            <label class="control-label control-document-name">@if ($entity->document_type == 2) CNPJ @else CPF @endif</label>
                            <div class="controls">
                                <input type="text" value="{{ $entity->document }}" name="document" required class="span3 login-input form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label control-name-doc">@if ($entity->document_type == 2) Razão Social @else Nome Completo @endif</label>
                        <div class="controls">
                            <input type="text" value="{{ $entity->corporate_name }}" name="corporate_name" required class="span3 login-input form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nome de Exibição</label>
                        <div class="controls">
                            <input type="text" value="{{ $entity->name }}" name="name" class="span3 login-input form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Atualizar Imagem</label>
                        <div class="controls" style="margin-bottom: 10px;">
                            <input type="file" name="image" lass="custom-file-input" accept="image/*" id="inputGroupFile01">
                        </div>
                        <a class="fancybox" style="color:#00bcd4 !important;font-size:14px;" rel="gallery" target="_blank" href="{{ url('uploads/'.$entity->image) }}">Visualizar imagem atual</a>
                    </div>

                    <div class="form-group">
                        <label class="control-label">E-mail de Login</label>
                        <div class="controls">
                            <input type="text" name="email" value="{{ $entity->user->email }}" class="span3 login-input form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <input type="text" name="phone" value="{{ $entity->phone }}" class="span3 login-input form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Endereço</label>
                                <div class="controls">
                                    <input type="text" name="address" value="{{ $entity->address }}" class="span3 login-input form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Bairro</label>
                                <div class="controls">
                                    <input type="text" name="neighborhood" value="{{ $entity->neighborhood }}" class="span3 login-input form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">CEP</label>
                                <div class="controls">
                                    <input type="text" name="cep" value="{{ $entity->cep }}" class="span3 login-input form-control" required>
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
                                <select class="form-control" name="city_id" required="required" id="city_id" data-selected="{{ $entity->city->id }}">
                                    <option value="">Selecione um estado...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Descrição de pagamento para doações</label>
                        <textarea class="form-control" rows="3" name="description_payment">{!! $entity->description_payment !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nova Senha</label>
                        <input type="password" class="form-control login-input" name="password" placeholder="Para alterar digite sua nova senha">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Confirmar Senha</label>
                        <input type="password" class="form-control login-input" name="password_confirmation" placeholder="Para alterar digite novamente sua nova senha">
                    </div>

                    <input type="submit" class="btn btn-primary" value="Salvar">
                </form>
            </div>
        </div>
</div>
@stop

@section('adminlte_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script>
        @if ($entity->document_type == 1)
            $('[name="document"]').mask('000.000.000-00', {reverse: true});
        @else
            $('[name="document"]').mask('00.000.000/0000-00', {reverse: true});
        @endif

        $('[name="phone"]').mask('(00) 0000-00009');

        $("#uf option[value={{ $entity->city->state->abbr  }}]").attr('selected','selected').change();

        change_city("{{ $entity->city->state->abbr }}", "{{ $entity->city->id }}");

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
    </script>
@stop
