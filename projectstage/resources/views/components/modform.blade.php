@props(['page' , 'activeData' , 'users'])

<style>

    #modForm input , #modForm textarea , #modForm select{
        outline: 1px solid black

    }

    #codeClient {
        outline: 1px solid black;
        outline-offset: 2px;
    }

    #modForm label {
        font-weight: bold;
    }

</style>

<div class="d-flex justify-content-center mt-3 mb-3">
    <form id="modForm" class="w-50" action="{{ route($page.'.update', $activeData) }}" method="POST">
        @csrf
        @method('put')
    
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <a href="{{ route($page.'.index') }}" class="btn btn-danger mb-2">Fermer</a>
                    </div>
                    @if(session('mod'))
                        <p class="alert fw-bold fs-5 alert-success alert-dismissible fade show" role="alert">{{ session('mod') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </p>
                    @endif
                    @if ($page != 'clients')
                        <div class="d-flex gap-3 mb-3">
                            <h3 id="codeClient" class="btn btn-dark fw-bold">{{ $activeData->clients->code }}</h3>
                            <h2 class="fw-bold">{{ $activeData->clients->nom }}</h2>
                        </div>
    
                        @if ($page == 'acompte')
                            @for ($i = 1; $i < 6; $i++)
                                <div class="form-group mb-3">
                                    <label for="">{{ $i == 1 ? 'Regularisation' : 'Trimestre ' . ($i - 1) }}</label>
                                    <div class="input-group">
                                        <input type="date" name="{{ 'date_depot_' . $i }}" class="form-control" placeholder="Date de dépôt" value="{{ $activeData->{'date_depot_'.$i} }}">
                                        <input type="text" name="{{ 'num_depot_' . $i }}" class="form-control" placeholder="Numéro de dépôt" value="{{ $activeData->{'num_depot_'.$i} }}">
                                        <input type="text" name="{{ 'motif_' . $i }}" class="form-control" placeholder="Motif" value="{{ $activeData->{'motif_'.$i} }}">
                                    </div>
                                </div>
                            @endfor
    
                        @elseif($page == 'tvat')
                            @for ($i = 1; $i < 5; $i++)
                                <div class="form-group mb-3">
                                    <label for="">Trimestre {{ $i }}</label>
                                    <div class="input-group">
                                        <input type="date" name="{{ 'date_depot_' . $i }}" class="form-control" placeholder="Date de dépôt" value="{{ $activeData->{'date_depot_'.$i} }}">
                                        <input type="text" name="{{ 'num_depot_' . $i }}" class="form-control" placeholder="Numéro de dépôt" value="{{ $activeData->{'num_depot_'.$i} }}">
                                        <input type="text" name="{{ 'motif_' . $i }}" class="form-control" placeholder="Motif" value="{{ $activeData->{'motif_'.$i} }}">
                                    </div>
                                </div>
                            @endfor
    
                        @elseif(in_array($page, ['bilan', 'etat', 'tp', 'irprof', 'pv', 'cm']))
                            <div class="form-group mb-3">
                                <label for="date_depot" class="form-label">Date de dépôt</label>
                                <input type="date" name="date_depot" class="form-control" value="{{ $activeData->date_depot }}">
                            </div>
    
                            <div class="form-group mb-3">
                                <label for="num_depot" class="form-label">Numéro de dépôt</label>
                                <input type="text" name="num_depot" class="form-control" placeholder="Numéro de dépôt" value="{{ $activeData->num_depot }}">
                            </div>
    
                            @if ($page == 'cm')
                                <div class="form-group mb-3">
                                    <label for="montant" class="form-label">Montant</label>
                                    <input type="number" name="montant" class="form-control" placeholder="Montant" value="{{ $activeData->montant }}">
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <label for="montant" class="form-label">Motif</label>
                                <input type="text" name="motif" class="form-control" placeholder="Motif" value="{{ $activeData->motif }}">
                            </div>

    
                        @else
                            @for ($i = 1; $i < 13; $i++)
                                <div class="form-group mb-3">
                                    <label for="">Mois {{ $i }}</label>
                                    <div class="input-group">
                                        <input type="date" name="{{ 'date_depot_' . $i }}" class="form-control" placeholder="Date de dépôt" value="{{ $activeData->{'date_depot_'.$i} }}">
                                        @if ($page != 'cnss')
                                            <input type="text" name="{{ 'num_depot_' . $i }}" class="form-control" placeholder="Numéro de dépôt" value="{{ $activeData->{'num_depot_'.$i} }}">
                                        @endif
                                        <input type="text" name="{{ 'motif_' . $i }}" class="form-control" placeholder="Motif" value="{{ $activeData->{'motif_'.$i} }}">
                                    </div>
                                </div>
                            @endfor
                        @endif
    
                    @else
                        <div class="form-group mb-3">
                            <label for="code" class="form-label">Code Client</label>
                            <input type="text" name="code" class="form-control" placeholder="Code client" required value="{{ $activeData->code }}">
                        </div>
    
                        <div class="form-group mb-3">
                            <label for="nom" class="form-label">Nom de l'entreprise</label>
                            <input type="text" name="nom" class="form-control" placeholder="Nom de l'entreprise" required value="{{ $activeData->nom }}">
                        </div>
    
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Forme juridique</label>
                            <div class="d-flex">
                                <input type="text" class="form-control w-25" style="border-radius:5px 0px 0px 5px" placeholder="PM/PP" readonly required value="{{ $activeData->status }}">
                                <select name="status" id="" class="form-control" style="border-radius:0px 5px 5px 0px">
                                    <option value="">Modifier la Forme juridique</option>
                                    <option value="PM">PM</option>
                                    <option value="PP">PP</option>
                                    <option value="SARLAU">SARLAU</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" placeholder="Adresse" required value="{{ $activeData->adresse }}">
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="IF" class="form-label">IF</label>
                                    <input type="text" name="IF" class="form-control" placeholder="IF" value="{{ $activeData->IF }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="TP" class="form-label">TP</label>
                                    <input type="text" name="TP" class="form-control" placeholder="TP" value="{{ $activeData->TP }}">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ICE" class="form-label">ICE</label>
                                    <input type="text" name="ICE" class="form-control" placeholder="ICE" value="{{ $activeData->ICE }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="CNSS" class="form-label">CNSS</label>
                                    <input type="text" name="CNSS" class="form-control" placeholder="CNSS" value="{{ $activeData->CNSS }}">
                                </div>
                            </div>
                        </div>
    
                        <div class="form-group mb-3">
                            <label for="RC" class="form-label">RC</label>
                            <input type="text" name="RC" class="form-control" placeholder="RC" value="{{ $activeData->RC }}">
                        </div>
    
                        <div class="form-group mb-3">
                            <label for="debut_activite" class="form-label">Date début d'activité</label>
                            <input type="date" name="debut_activite" class="form-control" value="{{ $activeData->debut_activite }}">
                        </div>
    
                        <div class="form-group mb-3">
                            <label for="activite" class="form-label">Activité</label>
                            <textarea name="activite" cols="30" rows="5" class="form-control" placeholder="Activité">{{ $activeData->activite }}</textarea>
                        </div>
                        
                        @if (auth()->user()->role == 'Admin')
                            <div class="form-group mb-3">
                                <label for="users_id" class="form-label">collaborateurs</label>
                                <select name="users_id" id="users_id" class="form-select" required>
                                    <option value="">Attribuer ce client à un collaborateur</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $activeData->users_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
    
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success mt-2">Sauvegarder</button>
                {{-- <a href="{{ route($page.'.index') }}" class="btn btn-danger mt-2">Fermer</a> --}}
            </div>
        </div>
    </form>
</div>


