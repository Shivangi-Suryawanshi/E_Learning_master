@extends(theme('layout-full'))

@section('content')

    @php
        $q_number = $answered->count() + 1;
        $q_limit = $attempt->questions_limit;
    @endphp

    <div class="question-top-nav py-3 px-4 bg-dark-blue text-white">
       
        <h4 class="m-0"><i class="la la-clipboard-list"></i> {{$quiz->title}}</h4>
        @if ($timeMove)
        @php
        // dd($convertSecond ,$convertMinut);
        $total = $convertSecond + $convertMinut ;
    @endphp
        <p  class="time">{{$timeMove}}</p>
        @else
        <p  class="time">{{$quiz->option('time_limit')}}:00</p>
        @endif
       
    </div>

    <div class="quiz-wrap mt-4">

        <div class="container">

            <div class="col-md-8 offset-md-2">

                <div class="question-wrap">

                    <form action="{{route('quiz_attempt_url', $quiz->id)}}" method="post" class="quiz-question-submit">
                        @csrf
                        
                       <input type="text" hidden name="timeMove" class="timeMove" >

                        <input type="hidden" name="question_type" value="{{$question->type}}">
                        @if($question->image_id)
                            <div class="quiz-image mb-3">
                                <img src="{{$question->image_url->original}}" />
                            </div>
                        @endif

                        <h2 class="question-title d-flex mb-3">
                            <span><i class="la la-question-circle mr-3"></i></span>
                            <span>{{$question->title}}</span>
                        </h2>

                        <div class="question-single-wrap">
                            @if( $question->type === 'radio' || $question->type === 'checkbox')
                                <div class="attempt-options-wrap d-flex mb-4">
                                    @foreach($question->options as $option)
                                        <div class="question-option">
                                            <label class="{{$question->type}} m-0">
                                                <input type="{{$question->type}}" name="questions[{{$question->id}}]{{$question->type === 'checkbox' ? '[]' : ''}}" value="{{$option->id}}"><span></span>
                                                {{$option->title}}
                                            </label>
                                        </div>

                                    @endforeach
                                </div>
                            @elseif($question->type === 'text' )
                                <div class="form-group">
                                    <input type="text" class="form-control copy-paste" name="questions[{{$question->id}}]" placeholder="Write your answer">
                                </div>
                            @elseif($question->type === 'textarea')
                            
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" name="questions[{{$question->id}}]" ></textarea>
                                    <p class="text-muted my-3"><small>Write your answer in details, you can write in multiple line</small></p>
                                </div>
                            @endif
                        </div>
                       

                        <button type="submit" name="question-submit-btn" class="btn btn-dark-blue btn-lg question-submit-btn">
                            @if($q_number == $q_limit)
                                Finish <i class="la la-angle-right"></i>
                            @else
                                Next <i class="la la-angle-right"></i>
                            @endif
                        </button>

                    </form>
                </div>


            </div>

        </div>
    </div>


    <div id="quiz-progress">
        @for($progress = 1; $progress <= $q_limit; $progress++)
            <span class="quiz-progress-number {{$progress == $q_number ? 'active' : ''}}">{{$progress}}</span>
        @endfor
    </div>

    <div id="questionRequiredAlertModal" class="modal" role="dialog">
        <div class="modal-dialog modal-alert">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4>You must answer the question:</h4>
                    <p>{{$question->title}}</p>
                    <button type="button" class="btn btn-info btn-wide" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div id="timOut" class="modal" role="dialog">
        <form action="{{route('quiz_attempt_url', $quiz->id)}}" method="get" >
        <div class="modal-dialog modal-alert">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4>You time is ended</h4>
                    <p>{{$question->title}}</p>
                    <button type="button" class="btn btn-info btn-wide" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </form>
    </div>

@endsection
@section('page-js')
    
<script>
    $('body').bind('copy paste',function(e) {
        // alert('ha');
    e.preventDefault(); return false; 
});
</script>

<script>
    
    function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
        $('.timeMove').val(display.textContent);
        console.log(display.textContent);
        if(display.textContent == "00:00")
        {
             $("#timOut")                                                                                                                                                                                                                                                                                           
      .modal("show")
      $('.time').html("00:00");
        }
    //   console.log(timer);
    }, 1000);
}

// window.onload = function () {
    var totalTime = $('.time').html();
   var timeConvert = totalTime.split(':');
    // console.log(tt[0]);
    var timeOne = timeConvert[0] * 60;
    var sum = parseInt(+timeOne + +timeConvert[1])
    var fiveMinutes =  sum;
  
        display = document.querySelector('.time');
    startTimer(fiveMinutes, display);
    // console.log(fiveMinutes);
// };

</script>
@endsection
