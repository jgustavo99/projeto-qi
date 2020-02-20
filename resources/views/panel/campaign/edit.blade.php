@extends('layouts.app')

@section('title', 'Donate - Editar Campanha')

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
                    <h2 class="heading5"><span class="maintext"> Editar Campanha</span></h2>

                    <div class="box">
                        @include('layouts.alerts')

                        <form class="loginform form-vertical" action="{{ route('campaigns.update', [$campaign->id]) }}" method="post" enctype="multipart/form-data">
                            <fieldset>
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
                                        <input type="file" name="image" class="custom-file-input" accept="image/*" id="inputGroupFile01">
                                    </div>
                                    <a class="fancybox" style="color:#00bcd4 !important;font-size:14px;" rel="gallery" href="{{ url('uploads/campaigns/'.$campaign->image) }}">Visualizar imagem atual</a>
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

                                <div class="btns">
                                    <input type="submit" name="enviarbtn" class="btn btn-orange btn-ok" value="Salvar">
                            </fieldset>
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
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'editor1' );

        $(".fancybox").fancybox();

        $('.amount').mask('000.000.000.000.000,00', {reverse: true});
    </script>
@endsection
