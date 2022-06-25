@extends('admin.index')
@section('content')

<div class="card">
    <div class="card-header">
    <h3 class="card-title" style="float:none;">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::open(['route' => 'admin.store', 'mathod' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('name', trans('admin.admin_name')) }}
                {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('admin.admin_name')] )}}
            </div>
            <div class="form-group">
                {{ Form::label('email', trans('admin.email')) }}
                {{ Form::email('email', old('email'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('password', trans('admin.password')) }}
                {{ Form::password('password', ['class' => 'form-control'] )}}
            </div>
            {{ Form::submit(trans('admin.new_admin'), ['class' => 'btn btn-primary'] )}}
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


@endsection