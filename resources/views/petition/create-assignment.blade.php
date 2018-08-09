@extends('layouts.template')

@section('title', 'Cadastrar analise' )
@section('pageTitle', 'Cadastrar analise')
@section('content')
    <form method="POST" action="{{action('PetitionController@saveAssign')}}">
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
                        <option>Selecione um projeto</option>
                        @foreach($petitions as $petition)
                            <option value="{{$petition->id}}">
                                {{ $petition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Voluntário</label>
                    <select name="volunteer_id" class="form-control">
                        <option>Selecione um Voluntário</option>
                        @foreach($volunteers as $volunteer)
                            <option value="{{$volunteer->id}}">
                                {{ $volunteer->user->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option>Selecione um Status</option>
                        @foreach($status as $s)
                            <option value="{{$s->id}}">
                                {{ $s->status }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
@endsection
