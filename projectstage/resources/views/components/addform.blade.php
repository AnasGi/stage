@props(['page' , 'activeData' , 'users' , 'clients'])

<style>

    .addCont {
        position: fixed;
        bottom: 10%;
        right: 12%;
        z-index: 2;
    }

    .addbtn {
        border-radius: 50%;
        width: 60px;
        cursor: pointer;
        box-shadow: 3px 3px 5px #818181;
    }

    .addmsg {
        order: -1;
        display: none;
        transition: .3s linear;
        font-weight: bold;
        background-color: #3422a6;
        color: white;              
        padding: 10px 15px;        
        border-radius: 15px;       
        font-size: 14px;
        text-transform: capitalize;
    }
    .addbtn:hover+.addmsg , .addbtn:hover {
        display: inline;
        transform: translate(1px , 1px)
    }

    #addForm {
        position: fixed;
        top: .5rem;
        width: 100%;
        height: 98%;
        z-index: 100;
        display: none;
        backdrop-filter: blur(3px);
    }
    #addForm form {
        overflow-y: scroll;
        width: 50%;
        height: 100%;
        padding: 15px;
        background-color: white;
    }
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
    .form-group {
        display: flex;
        align-items: center
    }

    @media screen and (max-width: 1100px) {
        #addForm form {
            width:60% !important;
        }

        
    }
</style>

<script>
    function showAddForm() {
        document.getElementById('addForm').style.display = 'flex';
        document.body.style.overflow = "hidden";
    }

    function closeAddForm(){
        document.getElementById('addForm').style.display = 'none';
        document.body.style.overflow = "auto";
    }
</script>
@if ($page != 'clients')
    @error('code')
        <p class="alert alert-danger fw-bold w-50 mt-3">Le code client que vous avez saisi n'existe pas!</p>
    @enderror
@endif

<div class="addCont d-flex justify-content-center align-items-center gap-2">
    <img src="{{asset ('imgs/add.png')}}" class="addbtn" alt="Ajouter" onclick="showAddForm()">
    <span class="addmsg shadow">Ajouter nouveaux données {{$page=='droittimbre' ? 'droit de timbre' : $page }}</span>
</div>


<div id="addForm">
    <form action="{{route($page.'.store')}}" method="POST" class="rounded shadow">
        @csrf    
        <h2 class="fw-bold">Ajouter des données 
            <span style="text-transform: uppercase;">
                {{$page=='droittimbre' ? 'droit de timbre' : $page }}
            </span>
        </h2>
        @if ($page != 'clients')
            <div class="form-group">
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
                        <label>{{ $i == 1 ? 'Regularisation' : 'Trimestre '.$i-1 }}</label>
                        <div class="input-group">
                            <input type="date" name="{{'date_depot_'.$i}}" class="form-control" placeholder="date_depot" />
                            <input type="text" name="{{'num_depot_'.$i}}" class="form-control" placeholder="numero_depot" />
                        </div>
                    </div>
                @endfor
    
            @elseif($page == 'tvat')
                @for ($i = 1; $i < 5; $i++)
                    <div class="form-group">
                        <label>Trimestre {{$i}}</label>
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
                    <label for="num_depot">Numéro de {{$page == 'pv' ? 'RC' : 'dépôt'}}</label>
                    <input type="text" name="num_depot" class="form-control" placeholder=""/>
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
                        <label>Mois {{$i}}</label>
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
                <input type="text" name="code" class="form-control" placeholder="Saisir un code client" required>
            </div>
            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom de l'entreprise" required>
            </div>
            <div class="form-group">
                <input type="text" name="adresse" class="form-control" placeholder="Adresse" required>
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
                <label>Date début d'activité</label>
                <input type="date" name="debut_activite" class="form-control">
            </div>
            <div class="form-group">
                <textarea name="activite" cols="30" rows="2" class="form-control" placeholder="Activité"></textarea>
            </div>
            <div class="form-group">
                <input type="text" name="ville" id="" placeholder="ville"  class="form-control">
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
    
        <div class="mt-2 p-2 shadow bg-light" style="position: sticky ; bottom:0" >
            <button type="submit" class="btn btn-success w-50 fw-bold">Ajouter</button>
            <button type="button" class="btn btn-danger fw-bold" onclick="closeAddForm()">Fermer</button>
        </div>
    </form>
</div>


@if ($page != 'clients')
    <p class="m-0 mt-1 fw-bold">Nombre des données: {{count($activeData)}}</p>
@endif