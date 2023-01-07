@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.add_language_screen') }}</h2>

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
                                    <label for="app_or_panel">{{ config('languageString.app_or_panel') }}<span
                                            class="error">*</span></label>
                                    <select class="form-control select2" id="app_or_panel" name="app_or_panel" required>
                                        <option value="">{{ config('languageString.select_option') }}</option>
                                        <option value="0">{{ config('languageString.admin_panel') }}</option>
                                        <option value="1">{{ config('languageString.app') }}</option>
                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.title') }} <span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name"
                                           id="name"
                                           placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.image') }} <span
                                            class="error">*</span></label>
                                    <input type="file" class="form-control dropify"
                                           name="image"
                                           id="image"/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.language-screen.index') }}"
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
    <!-- /row -->
@endsection
@section('js')
    <script src="{{URL::asset('assets/js/custom/languageScreen.js')}}?v={{ time() }}"></script>
@endsection
