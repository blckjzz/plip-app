@extends('layouts.template')

@section('title', $petition->name )
@section('pageTitle', 'Detalhes - '. $petition->name)
@section('content')
    <form>
        <div class="row p-1">
            <div class="col-sm-6">
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="csrf-token"/>
                <input type="hidden" name="petition_id" value="{{$petition->id}}">
                <input type="hidden" name="analysis_id" value="{{isset($petition->analise->id)}}">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-auto">
                                <div class="btn-group">

                                    <a href="{{ URL::previous() }}">
                                        <button type="button" class="btn btn-primary">Voltar</button>
                                    </a>
                                </div>
                                @if(Auth::user()->role->id == 1)
                                    <div class="btn-group">
                                        <a href="{{ action('PetitionController@edit', $petition->id)}}">
                                            <button type="button" value="Editar" class="btn btn-success">Editar
                                            </button>
                                        </a>
                                    </div>
                                @elseif(Auth::user()->role->id == 2)
                                    <a href="{{ action('VolunteerController@saveSelfAssign', $petition->id) }}">
                                        <button type="button" class="adotar btn btn-success">Adotar PL</button>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <fieldset disabled="disabled">
                            <h5 class="card-title">Análise do Projeto</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $petition->name }}</h6>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Texto de análise: </label> <span style="color: red">*</span>
                                    <textarea name="analisys_text" class="form-control"
                                              rows="12">{{isset($petition->analise->analisys_text)}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Leis usadas na análise</label> <span style="color: red">*</span>
                                    <textarea name="referral_law"
                                              class="form-control">{{isset($petition->analise->law_link)}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Eleitorado: </label> <span style="color: red">*</span>
                                    <input id='votes' value="{{isset($petition->analise->vote_number)}}"
                                           name="vote_number" min="0" type="number"
                                           class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="">Porcentagem do eleitorado necessário: </label><span
                                            style="color: red">*</span>
                                    <input id="percent" name="percent_votes" type="number" max="100" step="0.1"
                                           value="{{isset($petition->analise->percent_votes)}}"
                                           class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="">Mínimo do eleitorado necessário:</label> <span
                                            style="color: red">*</span>
                                    <input id="minimum" name="minimum_signatures" type="text" class="form-control"
                                           readonly="readonly"
                                           value="{{isset($petition->analise->minimum_signatures)}}">
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
                                       value="{{isset($petition->analise->status->status)}}">
                            </div>
                    </div>
                </div>
                </fieldset>
                <!-- Fim do Form da análise do Voluntário --->
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <form>

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
            </div>
        </div>
    </form>





@endsection
@section('scripts')
    @include('volunteer-dashboard.partials.confirmation-adoption')
@endsection