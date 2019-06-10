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
                <input type="hidden" name="petition_id" value="{{$analise->petition->id}}">
                <input type="hidden" name="analysis_id" value="{{$analise->id}}">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Minha análise</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $analise->petition->name }}</h6>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Texto de análise: </label> <span style="color: red">*</span>
                                <textarea name="analisys_text" class="form-control"
                                          rows="12">{{(old('analisys_text'))? old('analisys_text'): $analise->analisys_text}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Leis usadas na análise</label> <span style="color: red">*</span>
                                <textarea name="referral_law" class="form-control">{{(old('referral_law'))? old('referral_law'): $analise->law_link}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Eleitorado: </label> <span style="color: red">*</span>
                                <input id='votes' value="{{(old('vote_number'))? old('vote_number'): $analise->vote_number}}" name="vote_number" min="0" type="number"
                                       class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label for="">Porcentagem do eleitorado necessário: </label><span
                                        style="color: red">*</span>
                                <input id="percent" name="percent_votes" type="number" max="100" step="0.1" value="{{(old('percent_votes'))? old('percent_votes'): $analise->percent_votes}}" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label for="">Mínimo do eleitorado necessário:</label> <span
                                        style="color: red">*</span>
                                <input id="minimum" name="minimum_signatures" type="text" class="form-control" readonly="readonly"  value="{{(old('minimum_signatures'))? old('minimum_signatures'): $analise->minimum_signatures}}">
                            </div>


                            <div class="form-group">
                                <label for="">Status do projeto:</label>
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

@section('scripts')
    <script>
        $('#percent, #voters').on('keyup', function () {
            var percentil = 0;
            var voters = 0
            var amount = 0;
            percentil = $('#percent').val();
            voters = parseInt($('#votes').val());
            amount = voters * (percentil/100);
            $('#minimum').attr('value', amount);
            console.log(amount)
        });
    </script>
@endsection