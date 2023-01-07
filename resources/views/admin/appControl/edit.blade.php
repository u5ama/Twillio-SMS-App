@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{config('languageString.edit_app_control')}}</h2>

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
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $appControl->id }}">
                        <input type="hidden" id="form-method" value="edit">

                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="controls_key">{{config('languageString.app_control_key')}}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="controls_key"
                                           value="{{ $appControl->controls_key }}"
                                           id="controls_key"
                                           placeholder="{{config('languageString.app_control_key')}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="controls_value">{{config('languageString.app_control_value')}}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="controls_value"
                                           id="controls_value"
                                           value="{{ $appControl->controls_value }}"
                                           placeholder="{{config('languageString.app_control_value')}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label for="controls_message">{{config('languageString.app_control_message')}}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="controls_message"
                                           id="controls_message"
                                           value="{{ $appControl->controls_message }}"
                                           placeholder="{{config('languageString.app_control_message')}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{config('languageString.submit')}}</button>
                                        <a href="{{ route('admin.app-control.index') }}"
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
    <!-- /row -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{URL::asset('assets/js/custom/appControl.js')}}?v={{ time() }}"></script>
@endsection
