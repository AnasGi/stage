@props(['page' , 'activeData' , 'users' , 'clients'])

<style>
    

    #addForm input , #addForm textarea , #addForm select{
        margin: 10px 0px;
        outline: 1px solid black;
        border-radius: 0%;
    }

    #addForm label {
        font-weight: bold;
        display: inline-block;
        width: 250px
    }

    #addForm {
        padding: 10px 20px;
    }

    .addFormDetail {
        padding: 10px ;
        background-color: #D0ECE7;
        width: 40%;
        border-radius: 8px;
    }

    .addFormDetail summary {
        font-weight: bold;
        font-size: 18px
    }

    .form-group {
        display: flex;
        align-items: center
    }

    @media screen and (max-width: 1100px) {
        .addFormDetail {
            width:60% !important;
        }

        
    }
</style>

@error('code')
    <span class="alert alert-danger fw-bold">Le code client doit etre unique!</span>
@enderror

<details class="addFormDetail mb-2 mt-2">
    <summary>Ajouter nouveaux données {{$page}}</summary>
    <form id="addForm" action="{{route($page.'.store')}}" method="POST">
        @csrf    
        @if ($page != 'clients')
            <div class="form-group">
                <label for="">Code client</label>
                <input list="client-liste" name="code" class="form-control" placeholder="Choisir un client" required>
                <datalist id="client-liste">
                    @foreach ($clients as $client)
                        <option value="{{$client->code}}">{{$client->nom}}</option>
                    @endforeach
                </datalist> 
            </div>
    
            @if ($page == 'acompte')
                @for ($i = 1; $i < 6; $i++)
                    <div class="form-group">
                        <label for="">{{ $i == 1 ? 'Regularisation' : 'Trimestre '.$i-1 }}</label>
                        <div class="input-group">
                            <input type="date" name="{{'date_depot_'.$i}}" class="form-control" placeholder="date_depot" />
                            <input type="text" name="{{'num_depot_'.$i}}" class="form-control" placeholder="numero_depot" />
                        </div>
                    </div>
                @endfor
    
            @elseif($page == 'tvat')
                @for ($i = 1; $i < 5; $i++)
                    <div class="form-group">
                        <label for="">Trimestre {{$i}}</label>
                        <div class="input-group">
                            <input type="date" name="{{'date_depot_'.$i}}" class="form-control" placeholder="date_depot" />
                            <input type="text" name="{{'num_depot_'.$i}}" class="form-control" placeholder="numero_depot" />
                        </div>
                    </div>
                @endfor
    
            @elseif(in_array($page, ['bilan', 'etat', 'tp', 'irprof', 'pv', 'cm']))
                <div class="form-group">
                    <label for="date_depot">Date de dépôt</label>
                    <input type="date" name="date_depot" class="form-control" placeholder="date_depot"/>
                </div>
                <div class="form-group">
                    <label for="num_depot">Numéro de dépôt</label>
                    <input type="text" name="num_depot" class="form-control" placeholder="numero_depot"/>
                </div>
                @if ($page == 'cm')
                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <input type="number" name="montant" class="form-control" placeholder="montant"/>
                    </div>
                @endif
    
            @else
                @for ($i = 1; $i < 13; $i++)
                    <div class="form-group">
                        <label for="">Mois {{$i}}</label>
                        <div class="input-group">
                            <input type="date" name="{{'date_depot_'.$i}}" class="form-control" placeholder="date_depot"/>
                            @if ($page != 'cnss')
                                <input type="text" name="{{'num_depot_'.$i}}" class="form-control" placeholder="numero_depot"/>
                            @endif
                        </div>
                    </div>
                @endfor
            @endif
    
        @else
            <div class="form-group">
                <label for="">Code de client: </label>
                <input type="text" name="code" class="form-control" placeholder="Saisir un code supérieur a {{count($activeData)}}" required>
            </div>
            <div class="form-group">
                <label for="">Nom de l'entreprise: </label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="">Adresse: </label>
                <input type="text" name="adresse" class="form-control" required>
            </div>
            <div class="form-group">
                <select name="status" id="" class="form-control">
                    <option value="" required>Forme juridique</option>
                    <option value="PM">PM</option>
                    <option value="PP">PP</option>
                    <option value="SARLAU}}">SARLAU</option>
                </select>
                <input type="text" name="IF" class="form-control" placeholder="IF">
            </div>
            <div class="form-group">
                <input type="text" name="TP" class="form-control" placeholder="TP">
                <input type="text" name="ICE" class="form-control" placeholder="ICE">
            </div>
            <div class="form-group">
                <input type="text" name="CNSS" class="form-control" placeholder="CNSS">
                <input type="text" name="RC" class="form-control" placeholder="RC">
            </div>
            <div class="form-group">
                <label for="">Date début d'activité</label>
                <input type="date" name="debut_activite" class="form-control">
            </div>
            <div class="form-group">
                <textarea name="activite" cols="30" rows="2" class="form-control" placeholder="Activité"></textarea>
            </div>
            @if (auth()->user()->role == 'Admin')
                <div class="form-group">
                    <select name="users_id" id="users_id" class="form-control" required>
                        <option value="">Attribuer ce client à un collaborateur</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>            
            @endif
        @endif
    
        <button type="submit" class="btn btn-success mt-2 w-100">Ajouter</button>
    </form>
</details>

@if(session('add'))
    <p class="alert fw-bold fs-5 alert-success alert-dismissible fade show" role="alert">{{ session('add') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
@endif

@if ($page != 'clients')
    <p class="m-0 mt-4 fw-bold">Nombre des données: {{count($activeData)}}</p>
@endif