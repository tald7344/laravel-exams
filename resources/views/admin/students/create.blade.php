@extends('admin.index')
@section('content')

<div class="card">
    <div class="card-header">
    <h3 class="card-title" style="float:none;">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::open(['route' => 'student.store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('name', trans('admin.user_name')) }}
                {{ Form::text('name', old('name'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('username', trans('admin.username')) }}
                {{ Form::text('username', old('username'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('email', trans('admin.email')) }}
                {{ Form::email('email', old('email'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('password', trans('admin.password')) }}
                {{ Form::password('password', ['class' => 'form-control'] )}}
            </div>
            {{ Form::submit(trans('admin.new_user'), ['class' => 'btn btn-primary'] )}}
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


@endsection
