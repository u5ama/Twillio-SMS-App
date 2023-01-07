@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ config('languageString.change_password') }}</h4>

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
                    <form method="POST" data-parsley-validate="" id="changePasswordForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" value="" name="edit_value">
                        <input type="hidden" id="form-method" value="add">
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="current_password">{{ config('languageString.current_password') }}<span
                                            class="error">*</span></label>
                                    <input type="password" class="form-control"
                                           name="current_password" placeholder="{{ config('languageString.current_password') }}"
                                           id="current_password" required />
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="new_password">{{ config('languageString.new_password') }}<span
                                            class="error">*</span></label>
                                    <input type="password" class="form-control"
                                           name="new_password" placeholder="{{ config('languageString.new_password') }}"
                                           id="new_password" required />
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="confirmed_password">{{ config('languageString.confirmed_password') }}<span
                                            class="error">*</span></label>
                                    <input type="password" class="form-control"
                                           name="confirmed_password" placeholder="{{ config('languageString.confirmed_password') }}"
                                           id="confirmed_password" required />
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>


                        </div>

                        <div class="col-12">
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                    <button type="submit"
                                            class="btn btn-primary">{{ config('languageString.submit') }}</button>
                                    <a href="{{ route('admin.profile') }}"
                                       class="btn btn-secondary">{{ config('languageString.cancel') }}</a>
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
    <script src="{{URL::asset('assets/js/custom/password.js')}}?v={{ time() }}"></script>
@endsection
