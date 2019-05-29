@extends('layouts.template')

@section('title', $petition->name )
@section('pageTitle', 'Detalhes - '. $petition->name)
@section('content')
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-8">
                        <div class="btn-group">
                            <a href="{{ URL::previous() }}">
                                <button type="button" class="btn btn-primary">Voltar</button>
                            </a>
                        </div>
                        @if(isset($petition->analise->id))
                            <div class="btn-group">
                                <a href="{{ action('VolunteerController@getAnaliseView', $petition->analise->id)}}">
                                    <button type="button" class="btn btn-success">Minha Análise</button>
                                </a>
                            </div>
                        @endif

                        @if(!isset($petition->analise))
                            <div class="btn-group">
                                <a href="{{ action('VolunteerController@saveSelfAssign', $petition->id)}}">
                                    <button type="button" class="btn btn-success">Adotar PL</button>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Nome do projeto</label>
                            <input name="project_name" type="text" class="form-control" disabled
                                   value="{{$petition->name}}">
                        </div>


                        <div class="form-group">
                            <label for="">Nome fantasia do projeto</label>
                            <input name="fantasy_name" type="text" class="form-control" disabled
                                   value="{{$petition->fantasy_name}}">
                        </div>


                        <div class="form-group">
                            <label for="proponente">Proponente </label>
                            <input name="sender_name" type="text" class="form-control" disabled
                                   value="{{$petition->sender_name}}">
                        </div>
                        <div class="form-group">
                            <label for="">E-mail</label>
                            <input name="sender_mail" type="email" class="form-control"
                                   value="{{$petition->sender_mail}}"
                                   disabled>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Telefone:</label>
                                <input name="sender_phone" type="text" class="form-control"
                                       value="{{$petition->sender_telephone}}" disabled>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-8">
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
                        <input name="petition_status" type="text" class="form-control" disabled
                               value="{{$petition->status->status}}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleTextarea">Texto do projeto de lei</label>
                        <textarea name="petition_text" class="form-control" rows="10" disabled>
                                {{ $petition->text }}
                    </textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Abrangencia: </label> {{$petition->wide}}
                    </div>
                    <div class="form-group">
                        <label for="">Estado:</label> {{$petition->state}}
                    </div>
                    <div class="form-group">
                        <label for="">Municipio: </label> {{$petition->municipality}}
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection