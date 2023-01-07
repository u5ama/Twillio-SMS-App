@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.add_role') }}</h2>

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
                                    <label for="name">{{ config('languageString.name') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name"
                                           id="name"
                                           placeholder="{{ config('languageString.name') }}" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card mg-b-20">
                                    <div class="card-header pb-0">
                                        <div class="d-flex justify-content-between"><h4 class="card-title mg-b-0">
                                                {{ config('languageString.permission') }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                <thead>
                                                <tr>
                                                    <th>{{ config('languageString.module_name') }}</th>
                                                    <th>{{ config('languageString.create') }}</th>
                                                    <th>{{ config('languageString.read') }}</th>
                                                    <th>{{ config('languageString.update') }}</th>
                                                    <th>{{ config('languageString.delete') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($permissions as $permission)
                                                    <tr>
                                                        <th scope="row">{{$permission->module_name}}
                                                            <div class="form-check form-check-inline">
{{--                                                                <label class="ckbox mb-2 float-rightt">--}}
{{--                                                                    <input type="checkbox" name="permission[]"--}}
{{--                                                                           id="{{$permission->module_name}}"--}}
{{--                                                                           onclick="myFunction( {{$permission->module_name}})"--}}
{{--                                                                           value="1">--}}
{{--                                                                    <span>{{ config('languageString.select_all') }}</span>--}}
{{--                                                                </label>--}}
                                                            </div>
                                                        </th>

                                                        <?php
                                                        $pers = \Spatie\Permission\Models\Permission::where('module_name', $permission->module_name)->get();
                                                        ?>
                                                        @foreach($pers as $per)
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <label class="ckbox mb-2">
                                                                        <input type="checkbox" name="permission[]"
                                                                               id="{{$permission->module_name}}"
                                                                               value="{{$per->id}}">
                                                                        <span>{{$per->name}}</span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.role.index') }}"
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
    <script>
        function myFunction(value) {
            console.log(value);
        }
    </script>
    <script src="{{URL::asset('assets/js/custom/role.js')}}?v={{ time() }}"></script>
@endsection
