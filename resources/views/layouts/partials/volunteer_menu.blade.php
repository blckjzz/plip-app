<!---//inicio voluntario menu --->
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
    data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="fa fa-book nav-icon"></i>
            <p> Análise de projetos
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">

                <a href="{{ action('AnalysisController@index') }}" class="nav-link ">
                    <i class="fa fa-list nav-icon"></i>
                    <p>Minhas Análises</p>
                </a>
            </li>
            <li class="nav-item">

                <a href="{{ action('VolunteerController@getSelfAssignView') }}" class="nav-link ">
                    <i class="fa fa-book nav-icon"></i>
                    <p>Adote um PL</p>
                </a>
            </li>
        </ul>
    </li>

</ul>