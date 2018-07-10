@extends('layouts.template')

@section('title', $petition->name )
@section('content')
    {{ $petition->name }}
@endsection