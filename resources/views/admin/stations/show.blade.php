@extends('admin.layouts.master')
@section('css')
    <link href="{{URL::asset('assets/plugins/fancybox/jquery.fancybox.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">Location QR CODE</h2>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! QrCode::size(400)->generate($stations); !!}
                </div>
                <div class="border-top mb-3">
                    <button class="btn btn-primary card-title" onclick="callPrint()">Print QR Code</button>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>

    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        function callPrint() {
            window.print();
        }
    </script>
    <script src="{{URL::asset('assets/plugins/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{URL::asset('assets/js/custom/station.js')}}"></script>
@endsection
