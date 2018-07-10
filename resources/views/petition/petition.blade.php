@extends('layouts.template')

@section('title', 'Petitions')
    
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nome do Projeto</th>
            <th scope="col">Proponente</th>
            <th scope="col">Email</th>
            <th scope="col">Enviado em</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($petitions as $petition)
            <tr>
                <th>{{ $petition->id }}</th>
                <td><a href="{{ action('PetitionController@showPetition', $petition->id) }}">{{ str_limit($petition->name, 30) }} </a>
                <td>{{ $petition->sender_name }} </td>
                <td>{{ $petition->sender_mail }} </td>
                <td>{{ $petition->submitDate }} </td>
                <td>{{ $petition->status_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $petitions->links() }}

@endsection

