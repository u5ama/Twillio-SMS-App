@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">Edit App Menu</h2>

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
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $appMenu->id }}">
                        <input type="hidden" id="form-method" value="edit">

                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_image">Image<span
                                            class="error">*</span></label>
                                    <input type="file" class="form-control dropify"
                                           name="app_menu_image"
                                           id="app_menu_image" data-default-file="{{url($appMenu->image)}}"/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_icon">Icon<span
                                            class="error">*</span></label>
                                    <input type="file" class="form-control dropify"
                                           name="app_menu_icon"
                                           id="app_menu_icon" data-default-file="{{url($appMenu->icon)}}"
                                           />
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="app_menu_name">Name
                                            <span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="app_menu_name"
                                               id="app_menu_name"
                                               value="{{$appMenu->id}}"
                                               placeholder=" Name" required/>
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
                                           value="{{ $appMenu->slug }}"
                                           placeholder="Enter Slug" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="app_menu_type">Menu Type <span
                                            class="error">*</span></label>
                                    <select class="form-control select2" id="app_menu_type" name="app_menu_type" required>
                                        <option value="business_man" @if($appMenu->user_type == 'Passenger') selected @endif>Passenger</option>
                                        <option value="job_seeker" @if($appMenu->user_type ==  'Driver') selected @endif>Driver</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" name="menu_id" id="menu_id" value="{{$appMenu->id}}">
                                    <input type="hidden" name="user_type" id="user_type" value="{{$appMenu->user_type}}">
                                    <label for="app_menu_order">Select Order<span class="error">*</span></label>
                                    <select class="form-control" id="app_menu_order" name="app_menu_order" onchange="changeMyOrder()">
                                        @for ($i = 1; $i <= $indexes; $i++)
                                            <option value="{{ $i }}"  @if($appMenu->ordering==$i) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{config('languageString.submit')}}</button>
                                        <a href="{{ route('admin.app-menu.index') }}"
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
    <script src="{{URL::asset('assets/js/custom/appMenu.js')}}?v={{ time() }}"></script>
@endsection
