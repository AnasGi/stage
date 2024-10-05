<h2>{{auth()->user()->name}}</h2>
<p>{{auth()->user()->role}}</p>
<div class="d-flex gap-3 pb-3">
    <a href="/">Acceuil</a>
    <a href="{{route('clients.index')}}">Liste des clients</a>
    <a href="{{route('cnss.index')}}">CNSS</a>
    <a href="{{route('tvam.index')}}">Tva mensuelle</a>
    <a href="{{route('tvat.index')}}">Tva trimistrielle</a>
    <a href="{{route('ir.index')}}">Ir</a>
    <a href="{{route('droittimbre.index')}}">Droit de timber</a>
    <a href="{{route('acompte.index')}}">Acompte</a>
    <a href="{{route('etat.index')}}">Etat 9421</a>
    <a href="{{route('bilan.index')}}">Bilan</a>
    <a href="{{route('cm.index')}}">Cm</a>
    <a href="{{route('tp.index')}}">Tp</a>
    <a href="{{route('irprof.index')}}">IR Prof globale</a>
    <a href="{{route('pv.index')}}">PV de l'AGO</a>
    @auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>   
    @endauth
</div>