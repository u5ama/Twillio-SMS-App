@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.edit_address') }}</h2>

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
                        <input type="hidden" id="form-method" value="{{$address->id}}" name="edit_value">

                        <div class="row row-sm">

                            <div class="col-12 form-group mb-3">
                                <label for="address">{{config('languageString.address')}}<span
                                            class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                       name="address" placeholder="Address"
                                       id="address" value="{{$address->address}}" required autocomplete="off"/>

                                <input type="hidden" class="form-control" name="latitude" id="latitude"
                                       placeholder="Latitude" value="{{$address->latitude}}" required/>

                                <input type="hidden" class="form-control" name="longitude"
                                       id="longitude"
                                       placeholder="Longitude" value="{{$address->longitude}}" required/>
                            </div>
                            <div class="col-12">
                                <div id="map-canvas" style="height:300px;"></div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.userDetails',[$address->user_id]) }}"
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjbtflnGL0mEj7aHh9VOHPAa_0cqbJabY&libraries=places"
            async defer></script>

    <script src="{{URL::asset('assets/js/custom/userDetails.js')}}"></script>

    <script>
        // $(window).on('load', function () {
        //     $('#country_id').val(101).trigger('change');
        // });
        $(document).ready(function () {
            setTimeout(function () {
                initMap()
                $(function () {
                    addMarker('{{ $address->latitude }}', '{{ $address->longitude }}', '{{ $address->address }}')
                });
            }, 1000)
            setTimeout(function () {
                $("#address").attr("autocomplete", "new-password");
            }, 1100)
        });
    </script>
@endsection
