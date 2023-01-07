@extends('admin.layouts.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">Edit Bus</h2>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <style>
        .iti__flag-container {
            max-height: 40px !important;
        }
    </style>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $bus->id }}">
                        <input type="hidden" id="form-method" value="edit">
                        <input type="hidden" id="form-method" value="add">
                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Bus Name<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name"
                                           id="name"
                                           placeholder="Bus Name" value="{{ $bus->name }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="screen_info">Bus Contact Number<span
                                            class="error">*</span></label>
                                    <input class="form-control"
                                           name="mobile_no"
                                           id="mobile_no"
                                           placeholder="Bus Contact Number" value="{{ $bus->mobile_no }}" required type="text" maxlength="10"/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="screen_info">Bus Tag Number<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="tag_number"
                                           id="tag_number"
                                           placeholder="Bus Tag Number" value="{{ $bus->tag_number }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Bus Number<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="bus_number"
                                           id="bus_number"
                                           placeholder="Bus Number" value="{{ $bus->taxi_number }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ url('admin/buses') }}"
                                           class="btn btn-secondary">Cancel</a>
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

@endsection
@section('js')
    <script src="{{URL::asset('assets/js/custom/buses.js')}}?v={{ time() }}"></script>
@endsection
