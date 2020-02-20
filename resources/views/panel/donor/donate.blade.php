@extends('layouts.app')

@section('title', 'Donate - Minhas Doações')

@section('content')
    <!-- Content Start -->
    <div class="container mv100" style="margin-top:115px !important;margin-bottom: 40px !important;">
        <div class="row">
            <div class="col-md-12">
                <h2 style="text-align: center;color:#00bcd4 !important;margin-bottom:20px;font-weight:600">{{ $campaign->title }}</h2>

                <img src="{{ asset('uploads/campaigns/' . $campaign->image) }}" style="text-align: center;margin:auto;" class="img-responsive"/>

                <div class="box" style="margin-top:25px;font-size:15px !important;">
                    @include('layouts.alerts')

                    <form class="loginform form-vertical" action="{{ route('donations.donate', [$campaign->slug]) }}" method="post" enctype="multipart/form-data">
                        <fieldset>
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label">Valor da doação</label>
                                <div class="controls">
                                    <input type="text" name="amount" class="span3 login-input form-control amount" required>
                                </div>
                            </div>

                            <div class="btns" style="margin-top:15px;">
                                <input type="submit" name="enviarbtn" class="btn btn-orange btn-ok" value="Doar">
                        </fieldset>
                    </form>
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
        $('.amount').mask('000.000.000.000.000,00', {reverse: true});
    </script>
@endsection
