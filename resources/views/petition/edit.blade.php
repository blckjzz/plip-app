@extends('layouts.template')

@section('title', 'Edição - '. $petition->name )
@section('content')
    <form class="" method="POST" action="{{ action('PetitionController@save')}}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">

                    <a href="{{ URL::previous() }}">
                        <button type="button" class="btn btn-primary">Voltar</button>
                    </a>
                </div>
                <div class="btn-group">
                    <button type="submit" value="Salvar" class="btn btn-success" >Salvar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Nome do projeto</label>
                    <input name="project_name" type="text" class="form-control"  value="{{$petition->name}}">
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
                        <input name="sender_phone" type="text" class="form-control"
                               value="{{$petition->sender_telephone}}">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <div class="form-group">
                    <label>Referencias:</label> <a href="{{$petition->links}}" target="_blank">clique
                        aqui</a>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label for="">Video:</label> <a href="{{$petition->video_url}}" target="_blank">clique
                        aqui</a>
                </div>
            </div>
            <div class="form-group">
                <label for="">Enviado há:</label>
                <input name="petition_submit_date" type="text" class="form-control" disabled
                       value="{{$petition->submitDate->diffforhumans()}}">
            </div>
            <div class="form-group">
                <label for="proponente">Status do Projeto </label>
                <input name="status_id" type="text" class="form-control"
                       value="{{$petition->status->status}}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleTextarea">Texto do projeto de lei</label>
                <textarea name="petition_text" class="form-control" rows="10" >
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