@extends('layouts.app')

@section('title', 'Petitions')


@section('content')
    @foreach ($petitions as $petition)
        <li><a href="{{ action('PetitionController@showPetition', $petition->id) }}">{{ $petition->name }} </a></li>
    @endforeach

    {{ $petitions->links() }}

@endsection

