@extends('admin.index')
@section('content')

<div class="card">
    <div class="card-header">
    <h3 class="card-title" style="float:none;">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::open(['route' => 'answer.store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('exam', trans('admin.exam')) }}
                {{ Form::select('examId', App\Model\Exam::pluck('title', 'id'), old('examId'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('question', trans('admin.question')) }}
                {{ Form::select('questionId', App\Model\Question::pluck('title', 'id'), old('questionId'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('title', trans('admin.answer')) }}
                {{ Form::text('title', old('title'), ['class' => 'form-control'] )}}
            </div>
            <div class="form-group">
                {{ Form::label('order', trans('admin.order')) }}
                {{ Form::number('order', old('order'), ['class' => 'form-control', 'min' => 0] )}}
            </div>
            <div class="form-group">
                {{ Form::label('status', trans('admin.answer_status')) }}
                {{ Form::select('status', ['0' => trans('admin.not-correct'), '1' => trans('admin.correct')], old('status'), ['class' => 'form-control', 'style' => 'height:calc(2.25rem + 5px);'] )}}
            </div>

            {{ Form::submit(trans('admin.new_answer'), ['class' => 'btn btn-primary'] )}}
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->


@endsection
