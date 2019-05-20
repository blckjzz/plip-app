@extends('layouts.template')

@section('title', 'Petições disponíveis para Análise')
@section('pageTitle', 'Escolha as petições para analisar')
@section('content')
    <table class="" id="petitions">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nome do Projeto</th>
            <th scope="col">Proponente</th>
            <th scope="col">Email</th>
            <th scope="col">Enviado em</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($petitions as $petition)
            <tr>
                <th>{{ $petition->id }}</th>
                <td>
                    <a href="{{ action('PetitionController@showPetition', $petition->id) }}">{{ str_limit($petition->name, 30) }} </a>
                <td>{{ str_limit($petition->sender_name, 30) }} </td>
                <td>{{ str_limit($petition->sender_mail, 30) }} </td>
                <td>{{ $petition->submitDate->diffForHumans()}} </td>
                <td>{{ $petition->status->status }}</td>
                <td>

                    <a href="{{ action('PetitionController@showPetition', $petition->id) }}"><input
                                class="btn btn-primary" type="button" value="Ver detalhes"/>
                    </a>


                    <a href="{{ action('AnalysisController@create', $petition->id) }}"><input
                                class="btn btn-success" type="button" value="Adotar PL"/></a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#petitions').DataTable();
        });
    </script>
@endsection