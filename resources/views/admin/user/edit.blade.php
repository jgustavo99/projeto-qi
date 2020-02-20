@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content_header')
    <h1>Editar Usuário</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('users.update', [$user->id]) }}">
                    <input name="_method" type="hidden" value="PUT">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name" placeholder="Nome" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" name="email" id="email" placeholder="E-mail" required>
                    </div>

                    <div class="form-group">
                        <label for="document">Documento</label>
                        <input type="text" class="form-control document" value="{{ $user->document }}" name="document" id="document" placeholder="Documento" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" class="form-control phone" value="{{ $user->phone }}" name="phone" id="phone" placeholder="Telefone" required>
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

                    <input type="submit" class="btn btn-primary" value="Salvar">
                </form>
            </div>
        </div>
</div>
@stop

@section('adminlte_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script>
        $('[name="document"]').mask('000.000.000-00', {reverse: true});
        $('[name="phone"]').mask('(00) 0000-00009');

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
@stop
