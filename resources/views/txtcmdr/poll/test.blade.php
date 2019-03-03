@foreach($areas as $area => $positions)
{!! $area !!}
@foreach($positions as $position => $polls)
  {!! $position !!}
@foreach($polls as $index => $poll)
    {{ $index + 1 }}. {{ str_pad(str_limit(strtoupper($poll->candidate), 10, ""), 10, " ", STR_PAD_RIGHT) }}{{ str_pad(number_format($poll->votes), 10, " ", STR_PAD_LEFT) }}
@endforeach
@endforeach
@endforeach
