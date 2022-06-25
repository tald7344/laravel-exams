@if (!is_null($exam))
    <div class="info">
        <h1>{{$exam->title}}</h1>
    </div>

    <form class="steps" accept-charset="UTF-8" enctype="multipart/form-data" novalidate="" data-url="{{url('result')}}"
          id="quizStep">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="examId" value="{{$exam->id}}">
        <ul id="progressbar">
            @foreach($exam->questions as $key => $question)
                <li class="{{$key == 0 ? 'active' : ''}}" style="width: calc(100% / {{count($exam->questions)}})"
                    title="{{$question->title}}">{{words($question->title, '3', '')}}</li>
            @endforeach
        </ul>

        @foreach($exam->questions as $key => $question)
        <!-- USER INFORMATION FIELD SET -->
            <fieldset>
                <h2 class="fs-title">{{$question->title}}</h2>
                <!-- Begin What's Your First Name Field -->
                @if ($question->answers->isNotEmpty())
                    @foreach($question->answers as $answer)
                        <div class="hs_firstname field hs-form-field">
                            <input id="{{$answer->title}}-{{$answer->id}}" name="questionId-{{$question->id}}"
                                   required="required"
                                   type="radio" value="{{$answer->id}}" placeholder="" data-rule-required="true"
                                   data-msg-required="Please Select this if it correct"
                                   style="width: 25px; display: inline-block;">
                            <label for="{{$answer->title}}-{{$answer->id}}">{{$answer->title}}? *</label>
                            <span class="error1" style=" display: none;">
                                <i class="error-log fa fa-exclamation-triangle"></i>
                            </span>
                        </div>
                        <!-- End What's Your First Name Field -->
                    @endforeach
                @endif
            <!-- End Total Number of Constituents in Your Database Field -->
                @if (($key + 1) != '1')
                    <input type="button" data-page="{{$key + 1}}" name="previous" class="previous action-button" value="Previous"/>
                @endif
                @if (($key + 1) != count($exam->questions))
                    <input type="button" data-page="{{$key + 1}}" name="next" class="next action-button" value="Next"/>
                @endif
                @if (($key + 1) == count($exam->questions))
                    <input id="submit" class="hs-button primary large action-button next" type="submit" value="Submit">
                @endif
            </fieldset>
        @endforeach

        <fieldset>
            <div class="result-ajax hidden"></div>
            <div class="result-loader">
                <img class="" src="{{asset('design\style\img\loading.gif')}}">
            </div>
        </fieldset>
    </form>
@else
    <div class="jumbotron text-center">
        <h1>{{trans('admin.empty-questions')}}</h1>
        <p>.....</p>
    </div>

@endif
