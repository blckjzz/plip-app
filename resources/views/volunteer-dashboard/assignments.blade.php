@extends('layouts.template')

@section('title', 'Minhas análises')
@section('pageTitle', $title)
@section('content')
    @if(isset($analises) > 0)
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

            @foreach ($analises as $analise)
                <tr>
                    <th>{{ $analise->petition->id }}</th>
                    <td>
                        <a href="{{ action('VolunteerController@viewPetitionDetails', $analise->petition->id) }}">{{ str_limit($analise->petition->name, 30) }} </a>
                    <td>{{ str_limit($analise->petition->sender_name, 30) }} </td>
                    <td>{{ str_limit($analise->petition->sender_mail, 30) }} </td>
                    <td>{{ $analise->petition->submitDate->diffForHumans()}} </td>
                    <td>{{ $analise->petition->status->status }}</td>
                    <td>
                        <a href="{{ action('VolunteerController@viewPetitionDetails', $analise->petition->id) }}"><span
                                    class="fa fa-eye"></span>
                        </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @else
        <h3>Você não tem nenhuma petição. Que tal adotar uma? <a href="{{action('VolunteerController@getSelfAssignView')}}">clique aqui!</a></h3>
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#petitions').DataTable();
        });
    </script>
@endsection