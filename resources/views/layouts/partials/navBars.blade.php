<nav id="framework-top-nav" class="navbar navbar-expand-lg">

    <!----------------------------- LEFT COMPONENT ----------------------------------------->
    <div class="nav-left-part flex-center">
        <span class="nav-top-logo flex-center">
            <span class="nav-top-title-content flex-center"><a class="nav-top-title" href="{{ route('home') }}">{{env('APP_TRUE_NAME')}}</a></span>
        </span>

       <ul class="navbar-nav flex-center">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle listeBouton" data-toggle="dropdown" role="button">Employés<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.index') }}"><i class="fas fa-door-open"></i> Liste employés</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.creationEmployee') }}"><i class="far fa-eye"></i> Ajout employés</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle listeBouton" data-toggle="dropdown" role="button">Administration<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('task.index') }}"><i class="fas fa-door-open"></i> Tâches</a></li>
                    <li><a class="dropdown-item" href="{{ route('contract.index') }}"><i class="far fa-eye"></i> Contrats</a></li>
                    <li>
                        <a href="{{ route('task.administration') }}" class="dropdown-item">
                            <i class="fad fa-cogs"></i>
                            Administration
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('planning.index') }}">
                    Planning
                </a>
            </li>
        </ul>
    </div>

    <!----------------------------- RIGHT COMPONENT ----------------------------------------->
    <div class="nav-right-part flex-center">
        <ul class="navbar-nav flex-center">
            <li class="nav-item">
                <a class="nav-link" style="padding: 0.9rem !important" href="#">
                    Accès à GaLi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="padding: 0.9rem !important" href="#">
                    {{ date('Y') . ' ' .config('app.editor') }} All rights reserved
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="padding: 0.9rem !important">
                    {{ env('APP_VERSION') }}
                </a>
            </li>

            @guest
            <li class="nav-item">
                <a class="nav-link" style="padding: 0.9rem !important" href="{{ route('login') }}">Connexion</a>
            </li>
            @if(Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" style="padding: 0.9rem !important" href="{{ route('register') }}">Inscription</a>
                </li>
            @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" style="padding: 0.9rem !important" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
