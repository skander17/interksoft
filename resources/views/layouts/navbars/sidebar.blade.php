<div class="sidebar" data-color="azure" data-background-color="white" >
  <!--
        data-image="{ asset('material') }/img/sidebar-1.jpg"
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      Intercasas
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>Estadísticas</p>
        </a>
      </li>
        <li class="nav-item{{ $activePage == 'clients' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('clients.index') }}">
                <i class="material-icons">badge</i>
                <p>Clientes</p>
            </a>
        </li>

        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="material-icons">groups</i>
                <span class="sidebar-normal"> Lista de Usuarios </span>
            </a>
        </li>
        <li class="nav-item{{ $activePage == 'tickets' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('tickets.index') }}">
                <i class="material-icons">receipt</i>
                <span class="sidebar-normal"> Lista de Boletos </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#airCollapse" aria-expanded="true">
                <i class="material-icons">list</i>
                <p>Catalogos
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse {{($activePage == 'airlines' || $activePage == 'airports') ? 'active show' : '' }}" id="airCollapse">
                <ul class="nav">
                    <li class="nav-item{{ $activePage == 'airlines' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('airlines.index') }}">
                            <i class="material-icons">airplanemode_active</i>
                            <p>Aerolineas</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'airports' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('airports.index') }}">
                            <i class="material-icons">local_airport</i>
                            <p>Aeropuertos</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'countries' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('countries.index') }}">
                            <i class="material-icons">flag</i>
                            <p>Paises</p>
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <!--

        <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                <i class="material-icons">persons</i>
                <p>Usuarios
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse { ($activePage == 'profile' || $activePage == 'user-management') ? 'active show' : '' }" id="laravelExample">
                <ul class="nav">
                </ul>
            </div>
        </li>


        -->
    </ul>
  </div>
</div>
