@extends('admin.index')
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="float:none;">{{ $title }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <h3>{{$exam->title}}</h3>
            <div class="questions">
                @if ($exam->questions->isNotEmpty())
                    <div id="accordion" class="border">
                        <h5 class="p-2">{{trans('admin.questions')}} : </h5>
                        @foreach($exam->questions as $key => $question)
                            <div class="accordion-item border mx-2 mb-2">
                                <div id="heading{{$key}}">
                                    <h5 class="mb-0 position-relative">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                                data-target="#collapse{{$key}}" aria-expanded="true"
                                                aria-controls="collapse{{$key}}">
                                            {{$question->title}}
                                        </button>
                                        <span class="question-edit-icons position-absolute" style="{{lang() == 'en' ? 'right: 20px' : 'left: 20px'}}">
                                            <a href="{{route('question.edit', $question->id)}}" class=""><i class="fa fa-edit fa-xs"></i></a>
                                            {!! Form::open(['route' => ['question.destroy', $question->id], 'method' => 'POST', 'class' => 'd-inline-block']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::button(
                                                    '<i class="fa fa-trash text-danger fa-xs"></i>', [
                                                        'type' => 'submit',
                                                        'class' => 'border-0 bg-white',
                                                        'onclick' => "if(!confirm('". trans('admin.alert_delete_msg') . "')) return false;"
                                                    ])
                                                }}
                                            {!! Form::close() !!}
                                        </span>
                                    </h5>
                                </div>
                                @if($question->answers->isNotEmpty())
                                    <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}"
                                         data-parent="#accordion">
                                        <ul class="list-unstyled">
                                            @foreach($question->answers as $key => $answer)
                                                <li class="{{lang() == 'ar' ? 'mr-4' : 'ml-4'}} {{$answer->status ? 'text-success' : 'text-danger'}}">
                                                    <span
                                                        class="">{{trans('admin.answer') . ' ' . ($key + 1)}} : </span>
                                                    {{$answer->title}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div id="accordion" class="border p-2 text-center">{{trans('admin.empty-questions')}}</div>
                @endif
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


@endsection
