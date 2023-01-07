@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.edit_languageString') }}</h2>

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
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $languageString->id }}">
                        <input type="hidden" id="form-method" value="edit">
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_or_panel">{{ config('languageString.app_or_panel') }} <span
                                            class="error">*</span></label>
                                    <select class="form-control select2" id="app_or_panel" name="app_or_panel">
                                        <option value="0"
                                                @if($languageString->language_screen->app_or_panel==0) selected @endif>{{ config('languageString.admin_panel') }}</option>
                                        <option value="1"
                                                @if($languageString->language_screen->app_or_panel==1) selected @endif >{{ config('languageString.app') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="language_screen_name">{{ config('languageString.screen_name') }}<span
                                            class="error">*</span></label>
                                    <select class="form-control select2" id="language_screen_id" name="language_screen_id" required>
                                        <option value="">{{config('languageString.select_option')}}</option>
                                        @foreach($languageScreens as $languageScreen)
                                            @if($languageString->language_screen_id==$languageScreen->id)
                                                <?php  $s = "selected" ?>
                                            @else
                                                <?php  $s = "" ?>
                                            @endif
                                            <option
                                                value="{{$languageScreen->id}}" {{$s}}>{{$languageScreen->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="screen_name">{{ config('languageString.key') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name_key"
                                           id="name_key"
                                           readonly
                                           value="{{ $languageString->name_key }}"
                                           placeholder="Key" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            @foreach($languages as $language)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="{{ $language->language_code }}_name">{{ $language->name }} {{ config('languageString.name') }}
                                            <span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="{{ $language->language_code }}_name"
                                               id="{{ $language->language_code }}_name"
                                               @if($language->is_rtl==1) dir="rtl" @endif
                                               value="{{ $languageString->translateOrNew($language->language_code)->name }}"
                                               placeholder="{{ $language->name }} {{ config('languageString.name') }}"
                                               required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}</button>
                                        <a href="{{ route('admin.language-string.index') }}"
                                           class="btn btn-secondary">{{ config('languageString.cancel') }}</a>
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
    <script src="{{URL::asset('assets/js/custom/languageString.js')}}?v={{ time() }}"></script>
@endsection
