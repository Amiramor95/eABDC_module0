@extends('emails.layouts.simple')

@section('content')

<p>
    Hi, <br>
    Your TAC:
<h2>{{ $data['tac'] }}</h2> <br>
thanks
</p>

@endsection