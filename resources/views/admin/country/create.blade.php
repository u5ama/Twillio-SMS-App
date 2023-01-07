@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.add_country') }}</h2>

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
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Code">{{ config('languageString.phone_code') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="code"
                                           id="code"
                                           placeholder="Phone Code Name" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Code">{{ config('languageString.country_code') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="country_code"
                                           id="country_code"
                                           placeholder="Country Code" required/>
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
                                               placeholder="{{ $language->name }} {{ config('languageString.name') }}"
                                               required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tax_percentage">{{ config('languageString.timezone') }}<span
                                            class="error">*</span></label>
                                    <input type="text" name="timezone"
                                           class="form-control"
                                           placeholder="{{ config('languageString.timezone') }}"
                                           id="timezone" required>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            @foreach($languages as $language)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="{{ $language->language_code }}_tax_name">{{ $language->name }} {{ config('languageString.tax_name') }}
                                            <span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="{{ $language->language_code }}_tax_name"
                                               id="{{ $language->language_code }}_tax_name"
                                               @if($language->is_rtl==1) dir="rtl" @endif
                                               placeholder="{{ $language->name }} {{ config('languageString.tax_name') }}"
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
                                        <a href="{{ route('admin.country.index') }}"
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
    <script src="{{URL::asset('assets/js/custom/country.js')}}?v={{ time() }}"></script>
@endsection
