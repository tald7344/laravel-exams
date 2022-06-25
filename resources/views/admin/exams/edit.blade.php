@extends('admin.index')
@section('content')

<div class="card">
    <div class="card-header">
    <h3 class="card-title" style="float:none;">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::open(['route' => ['exam.update', $exam->id], 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('admin.exam_name')) }}
                {{ Form::text('title', $exam->title, ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('totalDegree', trans('admin.column_total_degree')) }}
                {{ Form::text('totalDegree', $exam->totalDegree, ['class' => 'form-control', 'placeholder' => trans('admin.placeholder_total_degree_default')] )}}
            </div>
            <div class="form-group">
                {{ Form::label('isActive', trans('admin.active')) }}
                {{ Form::select('isActive', ['1' => trans('admin.activate'), '0' => trans('admin.not-activate')], $exam->isActive, ['class' => 'form-control', 'style' => 'height:calc(2.25rem + 5px);'])}}
            </div>
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit(trans('admin.save'), ['class' => 'btn btn-primary'] )}}
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


@endsection
