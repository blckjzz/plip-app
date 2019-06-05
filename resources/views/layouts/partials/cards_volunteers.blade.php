<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ count(Auth::user()->volunteer->analises) > 0 ? Auth::user()->volunteer->analises->count(): "0" }}</h3>
                    <p>PL Adotados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file"></i>
                </div>
{{--                <a href="#" class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>--}}
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{(isset($analiseAprovada))? $analiseAprovada : 0}}</h3>
                    <p>Projetos Aprovados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-plus-square"></i>
                </div>
{{--                <a href="{{ action('PetitionController@showPetitionsInAnalysis')}}" class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{(isset($reprovadas))? $reprovadas : 0}}</h3>
                    <p>Projetos Reprovados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-angle-double-down"></i>
                </div>
{{--                <a href="#" class="small-box-footer"><i></i></a>--}}
            </div>
        </div>
    </div>
    <!-- /.row -->