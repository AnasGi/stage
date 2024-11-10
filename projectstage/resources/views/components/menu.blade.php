@props(['users'])

<style>
    .menu {
        background-color: rgb(238, 238, 238);
        padding: 10px 0px;
        z-index: 10;
    }

    .links a{
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        text-transform: capitalize;
    }

    .active-link {
        position: relative;
        background-color: rgb(111, 188, 111);
        color: black;
        border-color: green;
    }

    .active-link::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: green;
        border-radius: 10px;
        bottom: 0;
        left: 0;
        transform: translateY(5px);
    }


    .hr{
        width: 10px;
        color: black;
    }

    .online , .offline {
        width: 10px;
        height: 10px;
        background-color: lightgreen;
        border-radius: 100%
    }

    .offline {
        background-color: red;
    }

    .username:hover + span{
        visibility: visible !important;
    }

    @media screen and (max-width: 1100px) {
        
        .linksCont {
            overflow-x: auto !important;
            height: 50px;
        }
        .links {
            width: 150%;
        }
    }


</style>

<div class="menu shadow " style="z-index: 100">
    
    <div class="mb-3 d-flex justify-content-around align-items-center">
        <div>
            <img style="width: 150px; height:100px" src="{{asset('imgs/logo.png')}}" alt="logo"/>
        </div>
        <div>
            <div class="d-flex gap-3 align-items-center ">
                <div style="margin-right: 10px">
                    <div class="d-flex gap-1 align-items-start justify-content-center">
                        <h2 class="fw-bold">{{auth()->user()->name}}</h2>
                        <span class="bg-info p-1 fw-bold rounded" style="font-size: 14px ; text-transform:capitalize">{{auth()->user()->role}}</span>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        @if (auth()->user()->role == 'Admin')
                            <div class="dropdown">
                                <button class="btn btn-success p-1 dropdown-toggle fw-bold" style="font-size: 14px;width:200px" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Status des Collaborateurs
                                </button>
                                <ul class="dropdown-menu" style="width:500px">
                                    @foreach ($users as $item)
                                        @if ($item->role != 'Admin')
                                            <li style="font-size: 13px ; padding:5px 10px" class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($item->active)
                                                        <span class="online"></span>
                                                    @else
                                                        <span class="offline"></span>
                                                    @endif
                                                    <span class="username" style="cursor: pointer">{{$item->name}}</span>
                                                    <span style="visibility: hidden ; margin-left:10px" class="fw-bold">
                                                        <img src="{{asset('imgs/pass.png')}}" alt="mot de pass" width="15">
                                                        {{$item->passwordText}}
                                                    </span>
                                                </div>
                                                @if ($item->loggedout_at)
                                                    @if ($item->active)
                                                        <span style="font-size: 12px">En ligne</span>
                                                    @else
                                                        <span style="font-size: 12px">{{$item->loggedout_at}}</span>
                                                    @endif
                                                @endif
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                        @endif
                                    @endforeach
                                
                                </ul>
                            </div>
        
                        @endif
                        <a class="btn btn-primary p-1 fw-bold" href="{{route('user.edit' , auth()->user())}}" style="font-size: 14px">Modifier profile</a>
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger p-1 fw-bold" style="font-size: 14px">Déconexion</button>
                        </form>   
                    </div>
                </div>
                @endauth
            </div>
        </div>
        

    </div>

    <div class="mt-2 d-flex justify-content-between gap-1" >
        <div class="linksCont" style='width :{{auth()->user()->role == "Admin" ? "90%" : "100%"}}'>
            <div class="links d-flex justify-content-between gap-1" >
                <a class="btn btn-dark {{ Route::is('main.index') ? 'active-link' : '' }}" href="/">Acceuil</a>
                <a class="btn btn-dark {{ Route::is('clients.index') ? 'active-link' : '' }}" href="{{ route('clients.index') }}">Liste des clients</a>
                <hr class="hr">
                <a class="btn btn-light {{ Route::is('cnss.index') ? 'active-link' : '' }}" href="{{ route('cnss.index') }}">CNSS</a>
                <a class="btn btn-light {{ Route::is('tvam.index') ? 'active-link' : '' }}" href="{{ route('tvam.index') }}">Tva mensuelle</a>
                <a class="btn btn-light {{ Route::is('ir.index') ? 'active-link' : '' }}" href="{{ route('ir.index') }}">IR</a>
                <a class="btn btn-light {{ Route::is('droittimbre.index') ? 'active-link' : '' }}" href="{{ route('droittimbre.index') }}">Droit de timbre</a>
                <hr class="hr">
                <a class="btn btn-light {{ Route::is('tvat.index') ? 'active-link' : '' }}" href="{{ route('tvat.index') }}">Tva trimistrielle</a>
                <a class="btn btn-light {{ Route::is('acompte.index') ? 'active-link' : '' }}" href="{{ route('acompte.index') }}">Acompte</a>
                <hr class="hr">
                <a class="btn btn-light {{ Route::is('etat.index') ? 'active-link' : '' }}" href="{{ route('etat.index') }}">Etat 9421</a>
                <a class="btn btn-light {{ Route::is('bilan.index') ? 'active-link' : '' }}" href="{{ route('bilan.index') }}">Bilan</a>
                <a class="btn btn-light {{ Route::is('cm.index') ? 'active-link' : '' }}" href="{{ route('cm.index') }}">CM</a>
                <a class="btn btn-light {{ Route::is('tp.index') ? 'active-link' : '' }}" href="{{ route('tp.index') }}">TP</a>
                <a class="btn btn-light {{ Route::is('irprof.index') ? 'active-link' : '' }}" href="{{ route('irprof.index') }}">IR Prof globale</a>
                <a class="btn btn-light {{ Route::is('pv.index') ? 'active-link' : '' }}" href="{{ route('pv.index') }}">PV de l'AGO</a>
                @if (auth()->user()->role != 'Admin')
                    <hr class="hr">
                    <a href="{{ route('users.showTable') }}" class="btn btn-dark {{ Route::is('users.showTable') ? 'active-link' : '' }}">Dossiers clients</a>
                @endif
                
            </div>
        </div>
        @if (auth()->user()->role == 'Admin')
            <hr class="hr">
            <div class="dropdown">
                <button style="font-size: 13px" class="btn btn-dark fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Autres options
                </button>
                <ul class="dropdown-menu" style="font-size: 13px">
                  <li class="{{ Route::is('register.form') ? 'bg-body-secondary' : '' }}"><a class="dropdown-item" href="{{route('register.form')}}">Creer un Collaborateurs</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="{{ Route::is('users.show') ? 'bg-body-secondary' : '' }}">
                    <a class="dropdown-item" href="{{route('users.show')}}">Liste des Collaborateurs</a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="{{ Route::is('clients.deleted') ? 'bg-body-secondary' : '' }}">
                    <a class="dropdown-item" href="{{route('clients.deleted')}}">Décharge et Liquidation</a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="{{ Route::is('clients.history') ? 'bg-body-secondary' : '' }}">
                    <a class="dropdown-item" href="{{route('clients.history')}}">Historique</a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="{{ Route::is('clients.new') ? 'bg-body-secondary' : '' }}">
                    <a class="dropdown-item" href="{{route('clients.new')}}">Nouveaux clients</a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="{{ Route::is('stats.index') ? 'bg-body-secondary' : '' }}">
                    <a class="dropdown-item" href="{{route('stats.index')}}">Statistiques</a>
                  </li>
                </ul>
            </div>
        
        @endif
    </div>
</div>
