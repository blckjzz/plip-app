<!---//inicio voluntario menu --->
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
    data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    <li class="nav-item">

        <a href="{{ action('VolunteerController@getAnalisesView') }}" class="nav-link ">
            <i class="fa fa-list nav-icon"></i>
            <p>Meus PL's</p>
        </a>
    </li>
    <li class="nav-item">

        <a href="{{ action('VolunteerController@getSelfAssignView') }}" class="nav-link ">
            <i class="fa fa-book nav-icon"></i>
            <p>Adote um PL</p>
        </a>
    </li>

    </li>

</ul>