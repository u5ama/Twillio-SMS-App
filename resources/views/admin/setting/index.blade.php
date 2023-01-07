@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.setting') }}</h2>

            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="form-method" value="add">
                        <div class="row row-sm">
                            @foreach($settings as $setting)
                                <div class="col-12 form-group">
                                    <label for="color_key_field">{{config('languageString.'.$setting->meta_key)}}<span
                                                class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="{{ $setting->meta_key }}"
                                           value="{{ $setting->meta_value }}"
                                           id="{{ $setting->meta_key }}"
                                           placeholder="{{config('languageString.'.$setting->meta_key)}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            @endforeach

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-primary">{{ config('languageString.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{URL::asset('assets/js/custom/setting.js')}}?v={{ time() }}"></script>
    <script>
    </script>
@endsection
