@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <input type="hidden" value="{{$languageScreen->id}}" name="id" id="id">
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.language_screen') }}</h2>

            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('admin.language-screen.create') }}" class="btn btn-primary  mr-2">
                    <i class="mdi mdi-plus-circle"></i>{{ config('languageString.add_new') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <!--  Screen View -->
                        @if(!empty($languageScreen->image))
                            <a href="{{url($languageScreen->image)}}"
                               target="_blank"><img
                                    src="{{url($languageScreen->image)}}"></a>
                        @else
                            <a href="{{url('assets/img/sample.jpg')}}"
                               target="_blank"><img
                                    src="{{url('assets/img/sample.jpg')}}"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap" id="view-string">
                            <thead>
                            <tr>
                                <th>{{ config('languageString.no') }}</th>
                                <th>{{ config('languageString.app_or_panel') }}</th>
                                <th>{{ config('languageString.screen_name') }} </th>
                                <th>{{ config('languageString.key') }}</th>
                                <th>{{ config('languageString.value_ar') }}</th>
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
    <script src="{{URL::asset('assets/js/custom/languageScreen.js')}}"></script>
@endsection
