@extends('layouts.template')

@section('title', 'Edição - '. $petition->name )
@section('pageTitle', 'Edição - '. $petition->name)
@section('content')



    <form class="" method="POST" action="{{ action('PetitionController@save')}}">
        {{ csrf_field() }}
        <input name="id" type="hidden" class="form-control" value="{{$petition->id}}"/>
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">

                    <a href="{{ URL::previous() }}">
                        <button type="button" class="btn btn-primary">Voltar</button>
                    </a>
                </div>
                <div class="btn-group">
                    <button type="submit" value="Salvar" class="btn btn-success">Salvar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Nome do projeto</label>
                    <input name="name" type="text" class="form-control" value="{{$petition->name}}">
                </div>


                <div class="form-group">
                    <label for="">Nome fantasia do projeto</label>
                    <input name="fantasy_name" type="text" class="form-control"
                           value="{{$petition->fantasy_name}}">
                </div>


                <div class="form-group">
                    <label for="proponente">Proponente </label>
                    <input name="sender_name" type="text" class="form-control"
                           value="{{$petition->sender_name}}">
                </div>
                <div class="form-group">
                    <label for="">E-mail</label>
                    <input name="sender_mail" type="email" class="form-control" value="{{$petition->sender_mail}}">
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input name="sender_telephone" type="text" class="form-control"
                               value="{{$petition->sender_telephone}}">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <div class="form-group">
                    <label>Referencias:</label>

                    <textarea name="links" class="form-control" rows="3">
                                {{ $petition->links }}
                    </textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label for="">Video:</label>
                    <textarea name="video_url" class="form-control" rows="3">
                                {{ $petition->video_url }}
                    </textarea>

                </div>
            </div>
            <div class="form-group">
                <label for="">Enviado há:</label>
                <input name="submitDate" type="text" class="form-control" disabled
                       value="{{$petition->submitDate->diffforhumans()}}">
            </div>
            <div class="form-group">
                <label for="proponente">Status do Projeto </label>
                <select class="form-control" name="status_id">

                    @foreach($status as $s)
                        @if($s->id == $petition->status->id)
                            <option selected="selected" value="{{$s->id}}">
                                {{$s->status}}
                            </option>
                        @else
                            <option value="{{$s->id}}">
                                {{$s->status}}
                            </option>
                        @endif

                    @endforeach
                </select>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleTextarea">Texto do projeto de lei</label>
                    <textarea name="text" class="form-control" rows="10">
                                {{ $petition->text }}
                </textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Abrangencia: </label>
                    <input name="wide" type="text" class="form-control" value="{{$petition->wide}}">
                </div>
                <div class="form-group">
                    <label for="">Estado:</label>
                    <input name="state" type="text" class="form-control" value="{{$petition->state}}">
                </div>
                <div class="form-group">
                    <label for="">Municipio: </label> {{$petition->municipality}}
                    <input name="municipality" type="text" class="form-control" value="{{$petition->municipality}}">
                </div>
            </div>
    </form>



@endsection