@extends('layouts.template')

@section('title', $analise->petition->name )
{{--@section('pageTitle', "Análise do Projeto: ". $analise->petition->name)--}}
@section('content')
    <div class="row p-1">
        <div class="col-md-12">
            <div class="btn-group">
                <a href="{{ URL::previous() }}">
                    <button type="button" class="btn btn-outline-info">Voltar</button>
                </a>
            </div>
            <div class="btn-group">
                <button type="submit" form="form" id="cadastrarAnalise" class="btn btn-outline-success">Cadastrar
                    Análise
                </button>
            </div>
        </div>
    </div>
    <div class="row p-1">
        <div class="col-sm-6">
            <form method="post" id="form" action="{{ action('VolunteerController@cadastraAnalise')}}">
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="csrf-token"/>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Minha análise</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $analise->petition->name }}</h6>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Texto de análise: </label> <span style="color: red">*</span>
                                <textarea name="analisys_text" class="form-control"
                                          rows="12">{{$analise->analisys_text}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Leis usadas na análise</label> <span style="color: red">*</span>
                                <textarea name="referral_law" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Porcentagem do eleitorado necessário: </label> <span
                                        style="color: red">*</span>
                                <input name="percent_votes" type="number" min="0" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="">Eleitorado: </label> <span style="color: red">*</span>
                                <input name="vote_number" type="number" min="0" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label for="">Mínimo do eleitorado necessário: </label> <span
                                        style="color: red">*</span>
                                <input name="minimum_signatures" type="text" class="form-control" disabled>
                            </div>


                            <div class="form-group">
                                <label for="">Projeto Aprovado?</label>
                                <select name="status" class="form-control">
                                    <option disabled selected>Selecione um status</option>
                                    <option value="3">
                                        Reprovado
                                    </option>
                                    <option value="4">
                                        Reprovado - Inconstitucional
                                    </option>
                                    <option value="5">
                                        Aprovado
                                    </option>
                                </select>
                            </div>
                            <label for="proponente">Status do Projeto </label>
                            <input name="petition_status" type="text" class="form-control" disabled
                                   value="{{$analise->petition->status->status}}">
                        </div>
                    </div>
                </div>
            </form> <!-- Fim do Form da análise do Voluntário --->
        </div>


        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nome do projeto</label>
                                <input name="project_name" type="text" class="form-control" disabled
                                       value="{{$analise->petition->name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea">Texto do projeto de lei</label>
                                <textarea name="petition_text" class="form-control" rows="10"
                                          disabled>{{ $analise->petition->text }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Nome fantasia do projeto</label>
                                <input name="fantasy_name" type="text" class="form-control" disabled
                                       value="{{$analise->petition->fantasy_name}}">
                            </div>

                            <div class="form-group">
                                <label for="">Abrangencia: </label> {{$analise->petition->wide}}
                            </div>
                            <div class="form-group">
                                <label for="">Estado:</label> {{$analise->petition->state}}
                            </div>
                            <div class="form-group">
                                <label for="">Municipio: </label> {{$analise->petition->municipality}}
                            </div>


                            <div class="form-group">
                                <label for="proponente">Proponente </label>
                                <input name="sender_name" type="text" class="form-control" disabled
                                       value="{{$analise->petition->sender_name}}">
                            </div>
                            <div class="form-group">
                                <label for="">E-mail</label>
                                <input name="sender_mail" type="email" class="form-control"
                                       value="{{$analise->petition->sender_mail}}"
                                       disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Referencias:</label> <textarea class="form-control"
                                                                      rows="3">{{$analise->petition->links}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Video:</label> <textarea class="form-control"
                                                                       rows="3">{{$analise->petition->video_url}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection