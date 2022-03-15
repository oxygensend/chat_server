@extends('layouts.app')

@section('content')
    <div class="row  col-md-8  col-11 position-absolute border rounded top-50 start-50 translate-middle h-75">
        <div class="card border-0  h-100 w-25">
{{--            <users-panel/>--}}
            <div class="border-bottom">
                <h3 class="text-center">Users</h3>
            </div>

            <ul class="list-group mt-4 ">
                @foreach( $room->users as $user)
                <li class="d-flex justify-content-between align-items-center overflow-hidden mb-1">
                    {{ $user->name }}
                    <span class="p-2 bg-success translate-middle-x rounded-circle"></span>
                </li>
                 @endforeach

            </ul>

        </div>
        <div class="card border-0  border-start rounded-0 h-100 w-75">

           <chat-panel name="{{ $room->name }}"/>
        </div>
    </div>
@endsection
