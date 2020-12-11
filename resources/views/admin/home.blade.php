@extends('admin.layouts.app')
@section('title','Welcome To Admin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <a href="{{ route('candidates.index') }}">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$interview}}</h3>

              <p>Candidate</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
          </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <a href="{{ route('admincategory.index') }}">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$category}}</h3>

              <p>Category</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <a href="{{ route('hr.index') }}">
            <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$hr}}</h3>

              <p>HR</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
          </a>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{route('plan.index')}}">
              <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$plans}}</h3>

                <p>Plans</p>
              </div>
              <div class="icon">
                <i class="ion ion-briefcase"></i>
              </div>
            </div>
            </a>
          </div>
      </div>
      <h2 class="my-3">Recent Candidates</h2>
      <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>HR</th>
            <th>Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($recent_candidate as $index=>$item)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->getHrDetails->name}}</td>
                <td>{{$item->created_at}}</td>
                <td><a href="{{ route('candidates.show',$item->id) }}"><i class="fa fa-eye text-active"></i></a></td>
              </tr>

            @empty
              <tr>
                  <th colspan="7" class="text-center">No Record's Found</th>
              </tr>
            @endforelse


        </tbody>
      </table>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection
