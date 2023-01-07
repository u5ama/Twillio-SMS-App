@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.edit_admin') }}</h2>

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
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $user->id }}">
                        <input type="hidden" id="form-method" value="edit">
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.name') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name" value="{{$user->name}}"
                                           id="name"
                                           placeholder="{{ config('languageString.name') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">{{ config('languageString.email') }}<span
                                            class="error">*</span></label>
                                    <input type="email" class="form-control"
                                           name="email" value="{{$user->email}}"
                                           id="email" autocomplete="off"
                                           placeholder="{{ config('languageString.email') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mobile_no">{{ config('languageString.mobile_no') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="mobile_no" autocomplete="off"
                                           id="mobile_no" value="{{$user->mobile_no}}"
                                           placeholder="{{ config('languageString.mobile_no') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date_of_birth">{{ config('languageString.date_of_birth') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control datepicker-here"
                                           name="date_of_birth" autocomplete="off" value="{{$user->date_of_birth}}"
                                           id="date_of_birth"
                                           data-language="en"
                                           placeholder="{{ config('languageString.date_of_birth') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="gender">{{ config('languageString.gender') }}<span
                                            class="error">*</span></label>
                                    <label class="rdiobox">
                                        <input name="gender" value="Male" type="radio"
                                               @if($user->gender=='Male') checked @endif
                                               required>
                                        <span>{{ config('languageString.male') }}</span></label>
                                    <label class="rdiobox">
                                        <input name="gender" value="Female" type="radio"
                                               @if($user->gender=='Female') checked @endif
                                        >
                                        <span>{{ config('languageString.female') }}</span></label>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.user.index') }}"
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
    <script src="{{URL::asset('assets/js/custom/user.js')}}?v={{ time() }}"></script>
@endsection
