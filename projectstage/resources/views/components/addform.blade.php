@props(['page' , 'activeData' , 'users' , 'clients'])

<style>
    

    #addForm input , #addForm textarea , #addForm select{
        margin: 10px 0px 10px 0px;
        outline: 1px solid black

    }

    .addFormDetail {
        margin-bottom: 20px;
        padding: 10px 8px;
        background-color: rgba(228, 228, 228, 0.812);
        width: 30%
    }
</style>

@if(session('add'))
    <p class="alert fw-bold fs-5 alert-success">{{ session('add') }}</p>
@endif

@error('code')
    <span class="text-danger fw-bold fs-5">Le code client doit etre unique!</span>
@enderror

<details class="addFormDetail shadow">
    <summary>Ajouter nouvelles données {{$page}}</summary>
    <form id="addForm" action="{{route($page.'.store')}}" method="POST">
        @csrf    
        @if ($page != 'clients')
            <div class="form-group">
                <select name="code" id="client_code" class="form-control" required>
                    <option value="">Code client</option>
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
                <input type="text" name="code" class="form-control" placeholder="Code client" required>
            </div>
            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom de l'entreprise" required>
            </div>
            <div class="form-group">
                <input type="text" name="status" class="form-control" placeholder="PM/PP">
            </div>
            <div class="form-group">
                <input type="text" name="adresse" class="form-control" placeholder="Adresse" required>
            </div>
            <div class="form-group">
                <input type="text" name="IF" class="form-control" placeholder="IF">
            </div>
            <div class="form-group">
                <input type="text" name="TP" class="form-control" placeholder="TP">
            </div>
            <div class="form-group">
                <input type="text" name="ICE" class="form-control" placeholder="ICE">
            </div>
            <div class="form-group">
                <input type="text" name="CNSS" class="form-control" placeholder="CNSS">
            </div>
            <div class="form-group">
                <input type="text" name="RC" class="form-control" placeholder="RC">
            </div>
            <div class="form-group">
                <input type="date" name="debut_activite" class="form-control" placeholder="Date début d'activité">
            </div>
            <div class="form-group">
                <textarea name="activite" cols="30" rows="5" class="form-control" placeholder="Activité"></textarea>
            </div>
            <div class="form-group">
                <select name="users_id" id="users_id" class="form-control" required>
                    <option value="">Attribuer ce client à un responsable</option>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>            
            @endif
        @endif
    
        <button type="submit" class="btn btn-success mt-2">Ajouter</button>
    </form>
</details>
