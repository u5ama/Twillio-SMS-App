@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.edit_userVehicle') }}</h2>

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
                    <form method="POST" data-parsley-validate="" id="addVehicle" role="form">
                        @csrf
                        <input type="hidden" id="form-method" value="add">
                        <input type="hidden" id="form-method" value="{{$userVehicle->id}}" name="edit_value">
                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.name') }} <span
                                                class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name" value="{{$userVehicle->name}}" required
                                           id="name"/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="type">{{ config('languageString.vehicle_type_name') }}
                                        <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="type" class="form-control select2" id="type"
                                                style="width: 100%">
                                            <option value="">{{config('languageString.vehicle_type_name')}}</option>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}"
                                                        @if($type->id==$userVehicle->vehicle_type_id) selected @endif>{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="brand">{{ config('languageString.vehicle_brand_name') }}
                                        <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="brand" class="form-control select2" id="brands"
                                                style="width: 100%">
                                            <option
                                                    value="">{{config('languageString.vehicle_brand_name')}}</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}"
                                                        @if($brand->id==$userVehicle->brand_id) selected @endif>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label
                                            for="vehicle_model">{{ config('languageString.vehicle_model_name') }}
                                        <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="vehicle_model" class="form-control select2"
                                                id="vehicle_model" style="width: 100%">
                                            <option
                                                    value="">{{config('languageString.vehicle_model_name')}}</option>
                                            @foreach($models as $model)
                                                <option value="{{$model->id}}"
                                                        @if($model->id==$userVehicle->car_model_id) selected @endif>{{$model->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="year">{{ config('languageString.vehicle_year') }} <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="year" class="form-control select2" id="year"
                                                style="width: 100%">
                                            <option
                                                    value="">{{config('languageString.vehicle_year')}}</option>
                                            @foreach($years as $year)
                                                <option value="{{$year->id}}"
                                                        @if($year->id==$userVehicle->model_year_id) selected @endif>{{$year->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="body">{{ config('languageString.vehicle_body') }} <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="body" class="form-control select2" id="body"
                                                style="width: 100%">
                                            <option
                                                    value="">{{config('languageString.vehicle_body')}}</option>
                                            @foreach($bodies as $body)
                                                <option value="{{$body->id}}"
                                                        @if($body->id==$userVehicle->body_id) selected @endif>{{$body->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="fuel">{{ config('languageString.vehicle_fuel') }} <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="fuel" class="form-control select2" id="fuel"
                                                style="width: 100%">
                                            <option
                                                    value="">{{config('languageString.vehicle_fuel')}}</option>
                                            @foreach($fuels as $fuel)
                                                <option value="{{$fuel->id}}"
                                                        @if($fuel->id==$userVehicle->fuel_id) selected @endif>{{$fuel->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="fuel">{{ config('languageString.vehicle_engine') }}
                                        <span
                                                class="error">*</span></label>
                                    <div class="form-group">
                                        <select name="engine" class="form-control select2" id="engine"
                                                style="width: 100%">
                                            <option
                                                    value="">{{config('languageString.vehicle_engine')}}</option>
                                            @foreach($engines as $engine)
                                                <option
                                                        value="{{$engine->id}}"
                                                        @if($engine->id==$userVehicle->engine_id) selected @endif>{{$engine->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.userDetails',[$userVehicle->user_id]) }}"
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
    <script src="{{URL::asset('assets/js/custom/userDetails.js')}}?v={{ time() }}"></script>
@endsection



{{--<div class="modal-header">--}}
{{--    <h5 class="modal-title" id="globalModalTitle">Edit Vehicle</h5>--}}
{{--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--        <span aria-hidden="true">&times;</span>--}}
{{--    </button>--}}
{{--</div>--}}

{{--<form method="post" role="form" id="addVehicle" data-parsley-validate="">--}}
{{--    @csrf--}}
{{--    <div class="modal-body">--}}
{{--        <div class="row">--}}
{{--            <div class="col-xl-12">--}}
{{--                <div class="card d-block">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="clearfix"></div>--}}

{{--                        <input type="hidden" id="form-method" value="edit">--}}
{{--                        <input type="hidden" id="form-method" value="{{$userVehicle->id}}" name="edit_value">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label--}}
{{--                                        for="name">{{ config('languageString.name') }}--}}
{{--                                        <span--}}
{{--                                            class="error">*</span></label>--}}
{{--                                    <input type="text" class="form-control"--}}
{{--                                           value="{{$userVehicle->name}}"--}}
{{--                                           name="name" id="name" placeholder="name" required/>--}}
{{--                                    <div class="help-block with-errors error"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="modal-footer">--}}
{{--        <button type="submit"--}}
{{--                class="btn btn-secondary">{{ config('languageString.submit') }}--}}
{{--        </button>--}}
{{--        <button type="button" class="btn btn-secondary"--}}
{{--                data-dismiss="modal">Close--}}
{{--        </button>--}}
{{--    </div>--}}
{{--</form>--}}
