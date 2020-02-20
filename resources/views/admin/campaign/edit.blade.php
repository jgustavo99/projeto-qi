@extends('adminlte::page')

@section('title', 'Editar Campanha')

@section('content_header')
    <h1>Editar Campanha</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('layouts.alerts')

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.campaigns.update', [$campaign->id]) }}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="control-label">Título</label>
                        <div class="controls">
                            <input type="text" name="title" value="{{ $campaign->title }}" class="span3 login-input form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Valor meta</label>
                        <div class="controls">
                            <input type="text" name="amount_goal" value="{{ $campaign->amount_goal }}" class="span3 login-input form-control amount" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Data de vencimento</label>
                        <div class="controls">
                            <input class="form-control" type="date" value="{{ $campaign->close_at->format('Y-m-d') }}" name="close_at" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Atualizar Imagem</label>
                        <div class="controls" style="margin-bottom: 10px;">
                            <input type="file" name="image" lass="custom-file-input" accept="image/*" id="inputGroupFile01">
                        </div>
                        <a style="color:#00bcd4 !important;font-size:14px;" target="_blank" href="{{ url('uploads/campaigns/'.$campaign->image) }}">Visualizar imagem atual</a>
                    </div>

                    <label class="control-label" style="margin-bottom:10px !important;">Descrição</label>
                    <textarea name="description" id="editor1" rows="10" cols="80" required="required">{!! $campaign->description !!}</textarea>

                    <div class="form-group" style="margin-top:15px;">
                        <label class="control-label">Status</label>
                        <div class="controls">
                            <select class="form-control" name="status">
                                <option value="1" @if ($campaign->status == 1) selected @endif>Ativa</option>
                                <option value="2" @if ($campaign->status == 2) selected @endif>Encerrada</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Salvar">
                </form>
            </div>
        </div>
</div>
@stop

@section('adminlte_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'editor1' );

        $('.amount').mask('000.000.000.000.000,00', {reverse: true});
    </script>
@stop
