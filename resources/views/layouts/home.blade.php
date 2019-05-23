@extends('layouts.template')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')
@section('cards')
    @if(Auth::user()->role->id == 1)
        @include('layouts.partials.cards') <!-- Volunteer Mennu --->
    @elseif(Auth::user()->role->id == 2)
        @include('layouts.partials.cards_volunteers') <!-- Volunteer Mennu --->
    @endif

@endsection
@section('content')
