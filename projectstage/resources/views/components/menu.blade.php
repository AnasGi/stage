<style>
    .menu {
        position: sticky;
        top: 0;
        left: 0;
        background-color: rgb(238, 238, 238);
        padding: 10px 0px;
        z-index: 10;
    }

    .links a{
        text-decoration: none;
        font-size: 13px
    }

    .hr{
        width: 10px;
        color: black;
    }
</style>

<div class="menu shadow ">
    
    <div class="mb-3 d-flex justify-content-around align-items-center">
        <div>
            <div class="d-flex gap-3 align-items-center">
                <h2>{{auth()->user()->name}}</h2>
                <span class="bg-info p-1 fw-bold rounded" style="font-size: 12px">{{auth()->user()->role}}</span>
                <a class="btn btn-primary" href="{{route('user.edit' , auth()->user())}}">Modifier votre coordonnées</a>
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>   
                @endauth
            </div>
        </div>
        <div>
            <span class="btn btn-warning">{{ (new Datetime(Date('Y-m-d')))->format('d/m/Y') }}</span>
        </div>
    </div>
    <div class="links d-flex justify-content-between gap-1">
        <a class="btn btn-secondary" href="/">Acceuil</a>
        <a class="btn btn-secondary" href="{{route('clients.index')}}">Liste des clients</a>
        <hr class="hr">
        <a class="btn btn-secondary" href="{{route('cnss.index')}}">CNSS</a>
        <a class="btn btn-secondary" href="{{route('tvam.index')}}">Tva mensuelle</a>
        <a class="btn btn-secondary" href="{{route('ir.index')}}">Ir</a>
        <a class="btn btn-secondary" href="{{route('droittimbre.index')}}">Droit de timbre</a>
        <hr class="hr">
        <a class="btn btn-secondary" href="{{route('tvat.index')}}">Tva trimistrielle</a>
        <a class="btn btn-secondary" href="{{route('acompte.index')}}">Acompte</a>
        <hr class="hr">
        <a class="btn btn-secondary" href="{{route('etat.index')}}">Etat 9421</a>
        <a class="btn btn-secondary" href="{{route('bilan.index')}}">Bilan</a>
        <a class="btn btn-secondary" href="{{route('cm.index')}}">Cm</a>
        <a class="btn btn-secondary" href="{{route('tp.index')}}">Tp</a>
        <a class="btn btn-secondary" href="{{route('irprof.index')}}">IR Prof globale</a>
        <a class="btn btn-secondary" href="{{route('pv.index')}}">PV de l'AGO</a>
        @if (auth()->user()->role == 'Admin')
            <hr class="hr">
            <div class="dropdown">
                <button style="font-size: 13px" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Collaborateurs
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{route('register.form')}}">Creer un Collaborateurs</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <a class="dropdown-item" href="{{route('users.show')}}">Votre Collaborateurs</a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <a class="dropdown-item" href="{{route('stats.index')}}">Statistiques</a>
                  </li>
                </ul>
            </div>
        
        @endif
        
    </div>
</div>
