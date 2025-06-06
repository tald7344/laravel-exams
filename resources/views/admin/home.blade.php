@extends('admin.index')

@section('content')
{{--{{ dd($notExaminedStudents) }}--}}
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $isActiveExamsCount }}</h3>
            <p>{{ trans('admin.active-exams-count') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-document-text"></i>
          </div>
{{--          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
        </div>
      </div>
      <!-- ./col -->
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
              <h3>{{ $totalStudents }}</h3>
              <p>{{ trans('admin.total-students') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-people"></i>
          </div>
{{--          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
        </div>
      </div>
      <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalPassedPercent }}<sup style="font-size: 20px">%</sup></h3>
                    <p>{{ trans('admin.students-passed-percent') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                {{--          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
            </div>
        </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
              <h3>{{ $notExaminedStudents }}</h3>
              <p>{{ trans('admin.not-examined-students') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
{{--          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->

        <!-- TO DO List -->
          @include('admin.home.to-do-list')
        <!-- /.card -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">

        <!-- solid sales graph -->
        <!-- /.card -->

        <!-- Calendar -->
      @include('admin.home.calendar-home')
        <!-- /.card -->
      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->

@endsection
