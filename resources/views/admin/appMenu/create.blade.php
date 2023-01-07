@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">Add App Menu</h2>

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
                        <input type="hidden" id="edit_value" value="0" name="edit_value">
                        <input type="hidden" id="form-method" value="add">

                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_image">App Menu image<span
                                            class="error">*</span></label>
                                    <input type="file" class="form-control dropify"
                                           name="app_menu_image"
                                           id="app_menu_image" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_icon">App Menu Icon<span
                                            class="error">*</span></label>
                                    <input type="file" class="form-control dropify"
                                           name="app_menu_icon"
                                           id="app_menu_icon"
                                           required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="app_menu_name"> Name
                                            <span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="app_menu_name"
                                               id="app_menu_name"
                                               placeholder="Name" required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_slug">Slug<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="app_menu_slug"
                                           id="app_menu_slug"
                                           placeholder="Menu Slug" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_type">Menu Type <span
                                            class="error">*</span></label>
                                    <select class="form-control select2" id="app_menu_type" name="app_menu_type" required>
                                        <option value="Passenger">Passenger</option>
                                        <option value="Driver">Driver</option>
                                    </select>
                                </div>
                            </div>

                            {{--<div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_order">Select Order<span class="error">*</span></label>
                                    <select class="form-control" id="app_menu_order" name="app_menu_order">
                                        @for ($i = 1; $i <= $indexes; $i++)
                                            <option value="{{ $i+1 }}">{{ $i+1 }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>--}}

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">Submit</button>
                                        <a href="{{ route('admin.app-menu.index') }}"
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
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{URL::asset('assets/js/custom/appMenu.js')}}?v={{ time() }}"></script>
@endsection
