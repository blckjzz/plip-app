@extends('layouts.template')

@section('title', 'Petitions')
@section('pageTitle', 'Voluntarios')
@section('content')
    <table class="" id="voluntarios">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">Email</th>
            <th scope="col">Mudamos Mail</th>
            <th scope="col">Ações</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($voluntarios as $voluntario)
            <tr>
                <th>{{ $voluntario->id }}</th>
                <td>{{ str_limit($voluntario->user->name .' '. $voluntario->user->sobrenome, 30) }} </td>
                <td>{{ str_limit($voluntario->telephone, 30) }} </td>
                <td>{{ str_limit($voluntario->personal_email, 30) }} </td>
                <td>{{ str_limit($voluntario->user->email, 30) }} </td>
                <td>
                    <a href="{{ action('VolunteerController@show', $voluntario->id) }}"><span class="fa fa-eye"></span></a>
                    <a href="{{ action('VolunteerController@edit', $voluntario->id) }}"><span class="fa fa-pencil"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#voluntarios').DataTable();
        });
    </script>
@endsection