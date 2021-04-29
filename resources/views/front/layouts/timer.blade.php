@if($timer_takhfif->display_end_time > now())
    <span id='timer_0'
          data-seconds="{{$timer_takhfif->display_end_time->diffInSeconds(now())}}"
          class='timer'>
     </span>
@else
    <span id='timer_0'>پایان یافته</span>
@endif

