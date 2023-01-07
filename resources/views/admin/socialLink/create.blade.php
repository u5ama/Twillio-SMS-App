@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{config('languageString.add_social_link')}}</h2>

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
                                    <label for="title">{{config('languageString.title')}}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="title"
                                           id="title"
                                           placeholder="{{config('languageString.title')}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="social_key">{{config('languageString.social_key')}}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="social_key"
                                           id="social_key"
                                           placeholder="{{config('languageString.social_key')}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label for="url">{{config('languageString.url')}}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="url"
                                           id="url"
                                           placeholder="{{config('languageString.url')}}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="url">{{config('languageString.icon')}}<span
                                            class="error">*</span></label>
                                    <input type="file" class="form-control dropify"
                                           name="icon"
                                           id="icon" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{config('languageString.submit')}}</button>
                                        <a href="{{ route('admin.social-link.index') }}"
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
    <script src="{{URL::asset('assets/js/custom/socialLink.js')}}?v={{ time() }}"></script>
@endsection
