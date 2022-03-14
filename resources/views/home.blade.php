@extends('layouts.app')

@section('content')
    <x-form-card header="Choose room">
        <choose-room url="{{route('create')}}"/>
    </x-form-card>
@endsection
