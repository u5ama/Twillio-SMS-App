@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.add_smtp_credential') }}</h2>

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
                                    <label for="mail_driver">{{ config('languageString.mail_driver') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="mail_driver"
                                           id="mail_driver"
                                           placeholder="{{ config('languageString.mail_driver') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mail_host">{{ config('languageString.mail_host') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="mail_host"
                                           id="mail_host" autocomplete="off"
                                           placeholder="{{ config('languageString.mail_host') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mail_port">{{ config('languageString.mail_port') }}<span
                                            class="error">*</span></label>
                                    <input type="number" class="form-control"
                                           name="mail_port" autocomplete="off"
                                           id="mail_port"
                                           placeholder="{{ config('languageString.mail_port') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mail_username">{{ config('languageString.mail_username') }}<span
                                            class="error">*</span></label>
                                    <input type="email" class="form-control"
                                           name="mail_username" autocomplete="off"
                                           id="mail_username"
                                           placeholder="{{ config('languageString.mail_username') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mail_password">{{ config('languageString.mail_password') }}<span
                                            class="error">*</span></label>
                                    <input type="password" class="form-control"
                                           name="mail_password" autocomplete="off"
                                           id="mail_password"
                                           placeholder="{{ config('languageString.mail_password') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mail_encryption">{{ config('languageString.mail_encryption') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="mail_encryption" autocomplete="off"
                                           id="mail_encryption"
                                           placeholder="{{ config('languageString.mail_encryption') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mail_from_address">{{ config('languageString.mail_from_address') }}<span
                                            class="error">*</span></label>
                                    <input type="email" class="form-control"
                                           name="mail_from_address" autocomplete="off"
                                           id="mail_from_address"
                                           placeholder="{{ config('languageString.mail_from_address') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.smtp-credential.index') }}"
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
    <script src="{{URL::asset('assets/js/custom/smtpCredential.js')}}?v={{ time() }}"></script>
@endsection
