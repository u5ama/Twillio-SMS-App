@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.dashboard') }}</h2>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class=""><p class="mb-3 tx-14 text-white">Passengers</p></div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class=""><p class="tx-20 font-weight-bold mb-1 text-white">{{$passengers}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">
                    <canvas width="283" height="30"
                            style="display: inline-block; width: 283px; height: 30px; vertical-align: top;">
                    </canvas>
                </span>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class=""><p class="mb-3 tx-14 text-white">Drivers</p>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class=""><p class="tx-20 font-weight-bold mb-1 text-white">{{$drivers}}</p></div>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1"><canvas width="283" height="30"
                                                               style="display: inline-block; width: 283px; height: 30px; vertical-align: top;"></canvas></span>
            </div>
        </div>
        {{--<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class=""><p class="mb-3 tx-14 text-white">Gifts</p></div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <p class="tx-20 font-weight-bold mb-1 text-white">{{$gifts}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1"><canvas width="283" height="30"
                                                               style="display: inline-block; width: 283px; height: 30px; vertical-align: top;"></canvas></span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <p class="mb-3 tx-14 text-white">Earning</p>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <p class="tx-20 font-weight-bold mb-1 text-white">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1"><canvas width="283" height="30"
                                                               style="display: inline-block; width: 283px; height: 30px; vertical-align: top;"></canvas></span>
            </div>
        </div>
    </div>--}}


    {{--<div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <p class="card-title mb-0">User Vehicle Per Month</p>
                        <div class="d-flex my-xl-auto right-content">
                            <div class="mb-3 mb-xl-0">
                                <select name="year" id="year" class="form-control select2">
                                    <option value="">{{ config('languageString.year') }}</option>
                                    @for($i=2020;$i<=date('Y');$i++)
                                        <option value="{{$i}}" @if($i==date('Y')) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="userVehicleChart" class="sales-bar"></div>
                </div>
            </div>
        </div>
    </div>--}}

    {{--<div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <p class="card-title mb-0">User Per Month</p>
                        <div class="d-flex my-xl-auto right-content">
                            <div class="mb-3 mb-xl-0">
                                <select name="userYear" id="userYear" class="form-control select2">
                                    <option value="">{{ config('languageString.year') }}</option>
                                    @for($i=2020;$i<=date('Y');$i++)
                                        <option value="{{$i}}" @if($i==date('Y')) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="userChart" class="sales-bar"></div>
                </div>
            </div>
        </div>
    </div>--}}



@endsection
@section('js')
    <script>
        var options = "";
        var option = "";
        var userVehicle = "";
        var user = "";
        var chart = "";
    </script>

    <script src="{{asset('assets/js/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/custom/index.js')}}"></script>
    <script src="{{asset('assets/js/custom/userChart.js')}}"></script>
@endsection
