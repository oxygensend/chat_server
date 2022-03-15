@extends('layouts.app')

@section('content')
    <x-form-card  header="Create room">

        <create-room url="{{ route('home') }}" />

    </x-form-card>
@endsection
