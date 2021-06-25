@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ jlang('Action Name') }} {{App::getLocale()}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Post code') }}</label>

                            <div class="col-md-6">
                                <input id="zip" type="text" class="form-control" name="email" value="" onkeyup="JPostal.capture('#zip', ['#prefecture', '.city'])">
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
                                <input type="text" class="form-control city" name="prefecture">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Prefecture') }}</label>

                            <div class="col-md-6">
                                <select class="form-control selectPrefecture" id="selectPrefecture">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <select class="form-control selectCity" id="selectCity">
                                </select>
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
    JPostal.init();



    JPostal.innerPrefecturesHtml(function(prefectures){
        let selectTag = '<option value="">Prefecture</option>';
        for (const [key, value] of Object.entries(prefectures)) {
            selectTag += `<option value="${key}">${value}</option>`;
        }
        $('#selectPrefecture').append(selectTag);
    });

    $("#selectPrefecture").change(function(){
        JPostal.innerCityHtmlByPref('#selectPrefecture', function(cities){
            let selectTag = '<option value="">City</option>';
            for (const item in cities) {
                const {id, name} = cities[item];
                selectTag += `<option value="${id}">${name}</option>`;
            }
            $('#selectCity').append(selectTag);
        });
    });


    // $( "#zip" ).keyup(function() {
    //     JPostal.capture('#zip', function(data){
    //         console.log(typeof data);
    //         console.log(data);
    //     });
    // });
</script>
@endsection
