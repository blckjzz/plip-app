@extends('layouts.template')

@section('title', $petition->name )
@section('content')


    <form class="" action="#">

        <div class="form-group">
            <label for="proponente">Proponente </label>
            <input type="text" class="form-control" id="proponente" disabled value="{{$petition->sender_name}}">
        </div>
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="email" class="form-control" value="{{$petition->sender_mail}}" disabled>
        </div>

        <div class="form-group">
            <label for="">Nome do projeto</label>
            <input type="text" class="form-control" id="petitionName" disabled value="{{$petition->name}}">
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="">Estado:</label> {{$petition->sender_telephone}}
            </div>
        </div>

        <div class="form-group">
            <div class="form-group">
                <label for="">referencias:</label> <a href="{{$petition->video_url}}" target="_blank">clique aqui</a>
            </div>
        </div>


        <div class="form-group">
            <div class="form-group">
                <label for="">links:</label> <a href="{{$petition->links}}" target="_blank">clique aqui</a>
            </div>
        </div>

        <div class="form-group">
            <label for="">Enviado há:</label>
            <input type="text" class="form-control" id="petitionName" disabled
                   value="{{$petition->submitDate->diffforhumans()}}">
        </div>
        <div class="form-group">
            <label for="proponente">Status do Projeto </label>
            <input type="text" class="form-control" id="proponente" disabled value="{{$petition->status->status}}">
        </div>
        <div class="form-group">
            <label for="exampleTextarea">Texto do projeto de lei</label>
            <textarea class="form-control" rows="10" disabled>
            {{ $petition->text }}
        </textarea>
            <div class="form-group">
                <label for="">Estado:</label> {{$petition->state}}
            </div>
            <div class="form-group">
                <label for="">Municipio: </label> {{$petition->municipality}}
            </div>
            <div class="form-group">
                <label for="">É nacional?: </label> {{$petition->wide}}
            </div>
        </div>


    </form>

    <div class="btn-group">


        <a href="{{ URL::previous() }}">
            <input type="text" class="btn btn-md btn-info" value="Voltar">
        </a>

        <a href="{{ action('PetitionController@edit', $petition->id) }}">
            <input class="btn btn-md btn-success" value="Editar">
        </a>


    </div>

@endsection