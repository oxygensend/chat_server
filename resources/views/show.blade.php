@extends('layouts.app')

@section('content')
    {{ \Illuminate\Support\Facades\Session::get('room_token') }}
    <div class="row  col-md-8  col-11 position-absolute border rounded top-50 start-50 translate-middle h-75">
        <div class="card border-0  h-100 w-25">
            <users-panel :room='@json($room)' url="{{route('disconnect', $room)}}"/>

        </div>
        <div class="card border-0  border-start rounded-0 h-100 w-75">

           <chat-panel :room='@json($room)' user="{{\Illuminate\Support\Facades\Auth::id()}}"/>
        </div>
    </div>
@endsection
