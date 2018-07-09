@extends('layouts.app')

@section('title', 'Petitions')


@section('content')
    @foreach ($petitions as $petition)
        <li>{{ $petition->name }} </li>
    @endforeach

    {{ $petitions->links() }}

@endsection

