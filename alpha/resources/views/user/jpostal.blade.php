@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Action Name') }} {{App::getLocale()}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Post code') }}</label>

                            <div class="col-md-6">
                                <input id="zip" type="text" class="form-control" name="email" value="" onkeyup="JPortal.capture('#zip', ['#info'])">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Info') }}</label>

                            <div class="col-md-6">
                                <input id="info" type="text" class="form-control" name="info">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Prefecture') }}</label>

                            <div class="col-md-6">
                                <input id="prefecture" type="text" class="form-control" name="prefecture">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <input class="city" type="text" class="form-control" name="prefecture">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Capture') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/jpostal/jpostal.js') }}"></script>
<script type="text/javascript">
    JPortal.init();

    // $( "#zip" ).keyup(function() {
    //     JPortal.capture('#zip', function(data){
    //         console.log(typeof data);
    //         console.log(data);
    //     });
    // });
</script>
@endsection
