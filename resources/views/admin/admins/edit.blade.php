@extends('admin.index')
@section('content')

<div class="card">
    <div class="card-header">
    <h3 class="card-title" style="float:none;">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::open(['route' => ['admin.update', $admin->id], 'mathod' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('name', trans('admin.admin_name')) }}
                {{ Form::text('name', $admin->name, ['class' => 'form-control', 'placeholder' => trans('admin.admin_name')] )}}
            </div>
            <div class="form-group">
                {{ Form::label('email', trans('admin.email')) }}
                {{ Form::email('email', $admin->email, ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('password', trans('admin.password')) }}
                {{ Form::password('password', ['class' => 'form-control'] )}}
            </div>
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit(trans('admin.save'), ['class' => 'btn btn-primary'] )}}
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


@endsection