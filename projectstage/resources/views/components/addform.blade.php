@props(['page' , 'activeData' , 'users' , 'clients'])

<style>
    #addForm {
        position: absolute;
        background-color: rgb(246, 240, 230);
        padding: 10px;
        margin-top: 10px; 
        border-radius: 10px ;
    }

    #addForm input , #addForm textarea , #addForm select{
        margin: 5px 0px 5px 0px;
        outline: 1px solid black

    }

    #closeForm {
        display: flex;
        justify-content: end;
    }
</style>

@if(session('add'))
    <p class="alert alert-success">{{ session('add') }}</p>
@endif

<button id="addbtn" class="btn btn-dark">Ajouter nouvelles données {{$page}}</button>

<form id="addForm" action="{{route($page.'.store')}}" method="POST" class="w-25">
    @csrf    
    <div id="closeForm" class="w-100" >
        <span class="btn btn-danger">Fermer</span>
    </div>
    @if ($page != 'clients')
        <div class="form-group">
            <label for="client_code">Code client</label>
            <select name="code" id="client_code" class="form-control" required>
                <option value=""></option>
                @foreach ($clients as $client)
                    <option value="{{$client->code}}">{{$client->nom}}</option>
                @endforeach
            </select>
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
        @if (auth()->user()->role == 'Admin')
            <div class="form-group">
                <label for="client_code">Code client</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom de l'entreprise</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">PM/PP</label>
                <input type="text" name="status" class="form-control">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="if">IF</label>
                <input type="text" name="IF" class="form-control">
            </div>
            <div class="form-group">
                <label for="tp">TP</label>
                <input type="text" name="TP" class="form-control">
            </div>
            <div class="form-group">
                <label for="ice">ICE</label>
                <input type="text" name="ICE" class="form-control">
            </div>
            <div class="form-group">
                <label for="cnss">CNSS</label>
                <input type="text" name="CNSS" class="form-control">
            </div>
            <div class="form-group">
                <label for="rc">RC</label>
                <input type="text" name="RC" class="form-control">
            </div>
            <div class="form-group">
                <label for="debut_activite">Date début d'activité</label>
                <input type="date" name="debut_activite" class="form-control">
            </div>
            <div class="form-group">
                <label for="activite">Activité</label>
                <textarea name="activite" id="" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="users_id">Attribuer ce client à un responsable</label>
                <select name="users_id" id="users_id" class="form-control" required>
                    <option value=""></option>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endif

    <button type="submit" class="btn btn-success mt-2">Ajouter</button>
</form>


<script>
    document.getElementById('addForm').style.display = "none";
    document.getElementById('addbtn').addEventListener('click' , function(){
        document.getElementById('addForm').style.display = "block";
    })
    
    document.getElementById('closeForm').addEventListener('click' , function(){
        document.getElementById('addForm').style.display = "none";
    })
</script>