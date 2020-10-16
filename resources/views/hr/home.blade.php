@extends('hr.layouts.app')
@section('title','Welcome To HR')
@section('content')

<section class="content">
    <div class="container-fluid">
    <h5 class="my-3">Dashboard</h5>
            <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Candidate</span>
                        <span class="info-box-number">{{ $interview }}</span>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                <span class="info-box-icon bg-success"><i class="nav-icon fas fa-chart-pie"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Category</span>
                    <span class="info-box-number">{{ $category }}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            </div>
    </div>
</section>
@endsection

@section('js')

@endsection
