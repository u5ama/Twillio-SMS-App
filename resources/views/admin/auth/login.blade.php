@extends('admin.layouts.master2')

@section('content')
    <style>
        .btn-main-primary{
            color: #242525;
            background-color: #1F9AC6 !important;
            border-color: #1F9AC6 !important;
        }
    </style>
    <!-- Page -->
    <div class="page">
        <div class="container-fluid">
            <div class="row no-gutter" style="justify-content: center;">
                <!-- The image half  bg-primary-transparent -->
               {{-- <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex" id="loginBg">
                    <div class="row wd-100p mx-auto text-center" >
                        <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">

                        </div>
                    </div>
                </div>--}}
                <!-- The content half -->
                <div class="col-md-6 col-lg-6 col-xl-5">
                    <div class="login d-flex align-items-center py-2">
                        <!-- Demo content-->
                        <div class="container p-0">
                            <div class="row">
                                <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                    <div class="card-sigin">
                                        <div class="mb-5 d-flex text-center justify-content-center">
                                            <img src="{{URL::asset('assets/img/brand/logo.png')}}" alt="" style="width: 50%">
                                        </div>
                                        <div class="card-sigin">
                                            <div class="main-signup-header">
                                                <h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>
                                                <form action="{{ route('admin.login') }}"
                                                      method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input id="email" type="email"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               name="email"
                                                               value="{{ old('email') }}" required
                                                               autocomplete="email"
                                                               autofocus
                                                               placeholder="Enter Email">

                                                        @if ($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert"
                                                                  style="display: block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input id="password" type="password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               name="password"
                                                               required autocomplete="current-password"
                                                               placeholder="Enter Password">
                                                        @if ($errors->has('password'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                            @enderror
                                                    </div>
                                                    <button class="btn btn-main-primary btn-block" type="submit">Sign
                                                        In
                                                    </button>
                                                </form>
{{--                                                <div class="main-signin-footer mt-5">--}}
{{--                                                    <p><a href="{{ route('forget-password') }}">Forgot password?</a></p>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End -->
                    </div>
                </div><!-- End -->
            </div>
        </div>
    </div>
    <!-- End Page -->
@endsection
@section('js')
@endsection
