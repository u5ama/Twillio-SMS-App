@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{config('languageString.add_page')}}</h2>

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
                            @foreach($languages as $language)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="{{ $language->language_code }}_name">{{ $language->name }} {{ config('languageString.name') }}
                                            <span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               @if($language->is_rtl==1) dir="rtl" @endif
                                               name="{{ $language->language_code }}_name"
                                               id="{{ $language->language_code }}_name"
                                               placeholder="{{ $language->name }} Name" required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <div class="form-group">
                                    <label
                                        for="for">{{ config('languageString.for') }}
                                        <span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="for"
                                           id="for"
                                           placeholder="For" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="for">{{ config('languageString.slug') }}
                                            <span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="slug"
                                               id="slug"
                                               placeholder="Slug" required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>

                            @foreach($languages as $language)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="{{ $language->language_code }}_name">{{ $language->name }} {{ config('languageString.description') }}
                                            <span class="error">*</span></label>
                                        <textarea class="form-control description"
                                                  name="{{ $language->language_code }}_description"
                                                  id="{{ $language->language_code }}_description"
                                                  required>
                                        </textarea>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{config('languageString.submit')}}</button>
                                        <a href="{{ route('admin.page.index') }}"
                                           class="btn btn-secondary">{{config('languageString.cancel')}}</a>
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
    <script src="{{URL::asset('assets/js/custom/page.js')}}?v={{ time() }}"></script>
@endsection
