
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-file nav-icon"></i>
                <p> Petições
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ action('PetitionController@index') }}" class="nav-link ">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Lista de Projetos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{action('PetitionController@assign')}}" class="nav-link ">
                        <i class="fa fa-plus-circle nav-icon"></i>
                        <p>Cadastrar análise</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="fa fa-user-circle nav-icon"></i>
                <p> Voluntários
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">

                    <a href="{{ action('VolunteerController@index') }}" class="nav-link ">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Lista de Voluntários</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ action('VolunteerController@create') }}" class="nav-link ">
                        <i class="fa fa-plus-circle nav-icon"></i>
                        <p>Cadastrar Voluntário</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>