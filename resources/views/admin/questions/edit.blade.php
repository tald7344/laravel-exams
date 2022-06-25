@extends('admin.index')
@section('content')

<div class="card">
    <div class="card-header">
    <h3 class="card-title" style="float:none;">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::open(['route' => ['question.update', $question->id], 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('exam', trans('admin.exam')) }}
                {{ Form::select('examId', App\Model\Exam::pluck('title', 'id'), $question->examId, ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('title', trans('admin.question')) }}
                {{ Form::text('title', $question->title, ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('order', trans('admin.order')) }}
                {{ Form::number('order', $question->order, ['class' => 'form-control', 'min' => 0] )}}
            </div>
            <div class="form-group">
                {{ Form::label('degree', trans('admin.degree')) }}
                {{ Form::number('degree', $question->degree, ['class' => 'form-control', 'min' => 0] )}}
            </div>
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit(trans('admin.save'), ['class' => 'btn btn-primary'] )}}
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


@endsection
