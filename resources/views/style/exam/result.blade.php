<div class="result">
    <div class="container" style="padding: 5rem 0">
        <h1 class="text-center">( {{$exam->title}} ) {{trans('admin.result')}}</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-lg-offset-3 col-md-offset-2 col-sm-offset-1">
                <div class="row">
                    @foreach($exam->questions as $question)
                        <div class="col-xs-12">
                            <div class="question">
                                <h3>{{$question->title}}</h3>
                                @foreach($question->answers as $answer)
                                    @php
                                      $successClass = '';
                                      $icon = '';
                                      $studentAnswer = \App\Model\Result::where('studentId', Auth::id())
                                                                   ->where('examId', $exam->id)
                                                                   ->where('questionId', $question->id)
                                                                   ->where('answerId', $answer->id)->get();
                                        if ($studentAnswer->isNotEmpty()) {
                                            if (($answer->id == $studentAnswer->first()->answerId && $answer->status == true)) {
                                                $successClass = 'text-success';
                                                $icon = '<i class="fa fa-check-circle text-success"></i>';
                                            }
                                            if ($answer->id == $studentAnswer->first()->answerId && $answer->status == false) {
                                                $successClass = 'text-danger';
                                                $icon = '<i class="fa fa-times-circle text-danger"></i>';
                                            }
                                        } else {
                                            if (($answer->status == true)) {
                                                $successClass = 'text-success';
                                                $icon = '<i class="fa fa-check-circle text-success"></i>';
                                            }
                                        }
                                    @endphp
                                    <h5 class="{{$successClass}}" style="margin-{{lang() == 'en' ? 'left' : 'right'}}: 20px;">
                                        {{$answer->title}}
                                        {!! $icon !!}
                                    </h5>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="col-xs-12 text-center">
                        <div class="result-number">
                            @if (Auth::user()->status)
                                <h2 class="text-success">{{trans('admin.result-is')}} : {{Auth::user()->examDegree}} {{trans('admin.out-of')}} {{$exam->totalDegree}} ( {{trans('admin.success')}} )</h2>
                            @else
                                <h2 class="text-danger">{{trans('admin.result-is')}} : {{Auth::user()->examDegree}} {{trans('admin.out-of')}} {{$exam->totalDegree}} ( {{trans('admin.fail')}} )</h2>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 text-center">
                        <span data-href="{{url('result-csv')}}" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">{{trans('admin.export-csv')}}</span>
                    </div>
                </div>
            </div><!--.col-xs-12-->
        </div><!--.row-->
    </div>
</div>
