@extends('layouts.app')

@section('title', $petition->name )
@section('content')
    {{ $petition->name }}
@endsection