@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.user_details') }}</h2>
                <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12 py-2">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-title mb-3"></p>
                    <div class="row border-top  p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.name') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{$user->name}}</p>
                        </div>
                    </div>
                    <div class="row border-top border-bottom p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.creation_time') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{date('d-m-Y H:i:s',strtotime($user->created_at))}}</p>
                        </div>
                    </div>
                    <div class="row  border-bottom p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.email') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{$user->email}}</p>
                        </div>
                    </div>

                    <div class="row border-bottom p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.mobile_no') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{$user->mobile_no}}</p>
                        </div>
                    </div>

                    <div class="row border-bottom p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.gender') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{$user->gender}}</p>
                        </div>
                    </div>

                    <div class="row border-bottom p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.date_of_birth') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{$user->date_of_birth}}</p>
                        </div>
                    </div>

                    <div class="row border-bottom p-2">
                        <div class="col-md-6">
                            <p class="mb-0">{{ config('languageString.languages') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                @if($user->language)
                                    {{$user->language->name}}
                                @else

                                @endif
                            </p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ config('languageString.user_vehicle_details') }}</h4>
            </div>
        </div>
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#vehicleModal">
                <li class="mdi mdi-plus-circle"></li>{{ config('languageString.add_new') }}</button>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap" id="data-table">
                            <thead>
                            <tr>
                                <th>{{ config('languageString.no') }}</th>
                                <th>{{ config('languageString.creation_time') }}</th>
                                <th>{{ config('languageString.name') }}</th>
                                <th>{{ config('languageString.vehicle_type_name') }}</th>
                                <th>{{ config('languageString.brand_name') }}</th>
                                <th>{{ config('languageString.model_name') }}</th>
                                <th>{{ config('languageString.year') }}</th>
                                <th>{{ config('languageString.body_name') }}</th>
                                <th>{{ config('languageString.engine_name') }}</th>
                                <th>{{ config('languageString.fuel_name') }}</th>
                                <th>{{ config('languageString.is_filter') }}</th>
                                <th>{{ config('languageString.updation_time') }}</th>
                                <th>{{ config('languageString.actions') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    <!----vehicle modal start here---->

    <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="globalModalTitle">Add Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="globalModalDetails">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card d-block">
                                <div class="card-body">
                                    <div class="clearfix"></div>
                                    <form method="post" role="form" id="addVehicle" data-parsley-validate="">
                                        @csrf
                                        <input type="hidden" id="form-method" value="add">
                                        <input type="hidden" id="form-method" value="{{$user->id}}" name="user_id">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label
                                                            for="name">{{ config('languageString.name') }}
                                                        <span
                                                                class="error">*</span></label>
                                                    <input type="text" class="form-control"
                                                           name="name" id="name" placeholder="name" required/>
                                                    <div class="help-block with-errors error"></div>
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
                                                            <option
                                                                    value="">{{config('languageString.vehicle_type_name')}}</option>
                                                            @foreach($types as $type)
                                                                <option value="{{$type->id}}">{{$type->name}}</option>
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
                                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
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
                                                                <option value="{{$model->id}}">{{$model->name}}</option>
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
                                                                <option value="{{$year->id}}">{{$year->name}}</option>
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
                                                                <option value="{{$body->id}}">{{$body->name}}</option>
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
                                                                <option value="{{$fuel->id}}">{{$fuel->name}}</option>
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
                                                                        value="{{$engine->id}}">{{$engine->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit"
                                                        class="btn btn-secondary">{{ config('languageString.submit') }}
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----Vehicle modal end here---->

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ config('languageString.user_address_details') }}</h4>
            </div>
        </div>
        <div class="pr-1 mb-3 mb-xl-0">

            <a href="{{ route('admin.createAddress',[$user->id]) }}" class="btn btn-primary mr-2">
                <li class="mdi mdi-plus-circle"></li>
                {{ config('languageString.add_new') }}</button></a>

        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap" id="address-table">
                            <thead>
                            <tr>
                                <th>{{ config('languageString.no') }}</th>
                                <th>{{ config('languageString.creation_time') }}</th>
                                <th>{{ config('languageString.address') }}</th>
                                <th>{{ config('languageString.updation_time') }}</th>
                                <th>{{ config('languageString.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    {{--    <div class="modal fade" id="vehicleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
    {{--         aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">--}}

    {{--            <div class="modal-content" id="vehicleModalEditDetails">--}}

    {{--            </div>--}}

    {{--        </div>--}}
    {{--    </div>--}}

@endsection
@section('js')

    <script>
        var sweetalert_title = '{{config('languageString.user_vehicle_destroy')}}';
        var sweetalert_text = '{{config('languageString.sweetalert_text')}}';
        var confirmButtonText = '{{config('languageString.confirm')}}';
        var cancelButtonText = '{{config('languageString.cancel')}}';
        var address_title = '{{config('languageString.user_address_destroy')}}';
        var address_text = '{{config('languageString.sweetalert_text')}}';
    </script>
    <script src="{{URL::asset('assets/js/custom/userDetails.js')}}"></script>
@endsection
