@extends('layouts.template')
@section('title', 'Cadastro' )
@section('pageTitle', 'Cadastro de Voluntário')
@section('content')
    <div class="row p-1">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <div class="col-md-12">
                        <form action="{{ action('VolunteerController@store')}}" METHOD="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-auto">
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
                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Nome</label>
                                        <input name="name" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Sobrenome</label>
                                        <input name="sobrenome" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Senha</label>
                                        <input name="password" type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Telefone</label>
                                        <input name="telephone" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Email Mudamos</label> * será usado para login no deborador
                                        <input name="email" type="email" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Email pessoal</label>
                                        <input name="personal_email" type="email" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-auto">
                                    <div class="form-group">
                                        <label for="">Inicio do voluntariado: </label>
                                        <input name="volunteer_since" type="date"
                                               value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Observações & Notas</label>
                                        <textarea name="notes" class="form-control" rows="10"></textarea>
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