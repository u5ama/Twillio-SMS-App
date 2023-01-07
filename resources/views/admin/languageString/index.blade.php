@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.language_string') }} </h2>

            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('admin.language-string.create') }}" class="btn btn-primary  mr-2">
                    <i class="mdi mdi-plus-circle"></i> {{ config('languageString.add_new') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 input-group">
                            <select id="panel"
                                    class="form-control"
                                    required>
                                <option value="">{{ config('languageString.select_option') }}</option>
                                <option value="0">{{ config('languageString.admin_panel') }}</option>
                                <option value="1">{{ config('languageString.app') }}</option>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" value="filter" id="filter"
                                        aria-describedby="basic-addon2">
                                    {{ config('languageString.filter') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap" id="data-table">
                            <thead>
                            <tr>
                                <th>{{ config('languageString.id') }}</th>
                                <th>{{ config('languageString.app_or_panel') }}</th>
                                <th>{{ config('languageString.screen_name') }} </th>
                                <th>{{ config('languageString.key') }}</th>
                                <th>{{ config('languageString.value_ar') }}</th>
                                <th>{{ config('languageString.name') }}</th>
                                <th>{{ config('languageString.view_screen') }}</th>
                                <th>{{ config('languageString.actions') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const sweetalert_title = "{{ config('languageString.destroy_language_string').'?' }}";
        const sweetalert_text = "{{ config('languageString.sweetalert_text') }}";
        const status_msg = "{{ config('languageString.status_msg') }}";
        const confirmButtonText = "{{ config('languageString.yes_delete_it') }}";
        const cancelButtonText = "{{ config('languageString.no_cancel_plx') }}";
    </script>
    <script src="{{URL::asset('assets/js/custom/languageString.js')}}"></script>
@endsection
