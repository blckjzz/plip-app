@extends('layouts.template')

@section('title', 'Cadastrar analise' )
@section('pageTitle', 'Cadastrar analise')
@section('content')
    <div class="row p-1">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <div class="col-md-12">
                        <form id="cadastrar" method="POST" action="{{action('PetitionController@saveAssign')}}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group">

                                        <a href="{{ URL::previous() }}">
                                            <button type="button" class="btn btn-primary">Voltar</button>
                                        </a>
                                    </div>
                                    <div class="btn-group">


                                        <button type="Submit" value="Editar" class="btn btn-success">Cadastrar</button>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Projeto</label>
                                        <select name="project_id" class="form-control">
                                            <option selected="true" disabled="disabled">Selecione um projeto</option>
                                            @foreach($petitions as $petition)
                                                <option value="{{$petition->id}}">
                                                    {{ $petition->id .' - '.$petition->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Voluntário</label>
                                        <select name="volunteer_id" class="form-control">
                                            <option selected="true" disabled="disabled">Selecione um Voluntário</option>
                                            @foreach($volunteers as $volunteer)
                                                <option value="{{$volunteer->id}}">
                                                    {{ $volunteer->user->name .' '. $volunteer->user->sobrenome}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('#cadastrar').on('submit', function (e) {
                if (!confirm('Deseja criar essa tarefa? O voluntário receberá um e-mail após sua confirmação!')) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
                        }

                    });

                    e.preventDefault();


                }
            });
        });
    </script>
@endsection

