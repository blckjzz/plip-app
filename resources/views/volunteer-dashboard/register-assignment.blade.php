@extends('layouts.template')

@section('title', 'Cadastrar Análise - '. $petition->name )
@section('pageTitle', 'Análise  - '. $petition->name)
@section('content')
    <form class="" method="POST" action="{{ action('AnalysisController@store')}}">
        {{ csrf_field() }}
        <input name="petition_id" type="hidden" class="form-control" value="{{$petition->id}}"/>
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="/" target="_blank">
                        <button type="button" class="btn btn-primary">Voltar</button>
                    </a>
                </div>
                <div class="btn-group">
                    <button type="submit" value="Salvar" class="btn btn-success">Salvar Análise</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Nome do projeto</label>
                    <input name="name" type="text" class="form-control" value="{{$petition->name}}" disabled>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">Porcentagem assinaturas p/ PL de iniciativa popular (numérico)</label>
            <input id="percent" name="percent_votes" type="number" class="form-control"
                   value=" @if(isset($petition->analise->percent_votes))
                   {{ $petition->analise->percent_votes }} @endif"/>
        </div>

        <div class="form-group">
            <label for="">Número de Eleitores (<a
                        href="http://www.tse.jus.br/eleitor/estatisticas-de-eleitorado/consulta-quantitativo"
                        target="_blank">consulte aqui</a>)</label>
            <input id="voters" name="vote_number" type="number" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="">Mínimo de assinaturas</label>
            <input id="minimum" name="minimum_signatures" type="number" class="form-control"
                   readonly/>
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
                <div class="form-group">
                    <label>Parecer:</label>
                    <textarea name="analisys_text" class="form-control"
                              rows="5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label>Lei Orgânica / Constituição Estadual / Constituição Federal (texto)</label>
                    <textarea name="referral_law" class="form-control" rows="5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label>Link para legislação (link)</label>
                    <input name="law_link" class="form-control"/>
                </div>
            </div>


        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $('#percent, #voters').on('keyup', function () {
            var percentil = 0;
            var voters = 0
            var amount = 0;
            percentil = parseInt($('#percent').val());
            voters = parseInt($('#voters').val());
            amount = parseInt(voters * percentil / 100);
            $('#minimum').attr('value', amount);
            $('#test').attr('value', amount);
        });
    </script>
@endsection