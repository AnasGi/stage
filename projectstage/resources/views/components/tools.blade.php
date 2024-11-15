@props(['page' , 'activeData' , 'users'])

<style>
    

    .tools {
        padding: 10px;
        height: 100%;
        background-color: #D0ECE7;
        border-radius: 8px;
    }

    .tools summary {
        font-weight: bold;
        font-size: 18px
    }

    .tools form {
        padding: 10px 0px;
    }

    @media screen and (max-width: 1100px) {
        .tools {
            width: 100% !important;
        }
    }
</style>

<div class="d-flex gap-2 align-items-start mt-3 mb-2">
    <details class="tools" style="width: 70%" open>
        <summary style="text-transform: uppercase">
            <img src="{{asset('imgs/filter.png')}}" alt="Rechercher" width="20">
            Recherche par</summary>    
        <form action="{{route($page.'.index')}}" class="pb-0">
            <div class="searchForm d-flex gap-2 flex-wrap" style="margin-bottom: 11px">
                <div>
                    <input type="text" name="annee" class="form-control" id="" value="{{ request('annee') }}" placeholder="Année">
                </div>

                @if($page == 'clients')
                    <div>
                        <input type="text" name="mois" class="form-control" id="" value="{{ request('mois') }}" placeholder="Mois">
                    </div>
                @endif

                <div>
                    <input list="liste-clients-1" name="code" class="form-control" value="{{ request('code') }}" placeholder="Code de client:">
                    <datalist id="liste-clients-1">
                        @if($page == 'clients')
                            @foreach ($activeData as $data)
                                <option value="{{$data->code}}">{{$data->nom}}</option>
                            @endforeach
                        @endif
                    </datalist> 
                </div>

                @if ($page == 'etat' || $page == 'bilan' || $page == 'cm' || $page == 'tp' || $page == 'irprof' || $page == 'pv')
                    <div>
                        <input type="date" name="date" class="form-control" id="" value="{{ request('date') }}" placeholder="Date de depot"/>
                    </div>
                    @if ($page == 'pv')
                        <div>
                            <input list="liste-nums" name="rc" class="form-control" value="{{ request('rc') }}" placeholder="Numero de RC">
                            <datalist id="liste-nums">
                                @foreach ($activeData as $data)
                                    <option value="{{$data->num_depot}}">{{$data->num_depot}}</option>
                                @endforeach
                            </datalist>                         
                        </div>
                    @endif
                @endif

                @if (auth()->user()->role == 'Admin')
                    <div>
                        <select name="name" id="" class="form-control">
                            <option value="{{auth()->user()->id}}">{{auth()->user()->name}}</option>
                            @foreach ($users as $user)
                                @if ($user->role != "Admin")
                                    @if($user->id == request('name'))
                                        <option selected value="{{$user->id}}">{{$user->name}}</option>
                                    @else
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-start mb-1">
                <div>
                    <button style="padding: 3px 10px" class="btn btn-primary p-3 pt-1 pb-1" >Filtrer</button>
                </div>
                <div>
                    <a style="padding: 3px 10px" href="{{route($page.'.index')}}" class="btn btn-danger p-3 pt-1 pb-1">Initialiser filtrage</a>
                </div>
            </div>
        </form>
    </details>

    @if (auth()->user()->role == 'Admin' && $page == 'clients')
        <details class="tools" style="width: 30%">
            <summary style="text-transform: uppercase">Importer des données Excel</summary>    
            <form action="{{ route($page.'.import') }}" method="POST" enctype="multipart/form-data" id="ImportForm" >
                @csrf
                <div class="d-flex align-items-center flex-wrap">
                    <input class="w-75" type="file" name="file" id="file" accept=".csv"  class="form-control">
                    <button type="submit" class="btn btn-dark w-25" style="padding: 3px 10px">Importer</button>
                </div>
            </form>
            <p id="ImportError" class="alert alert-danger mb-1 p-2">Choisir un fichier avec éxtension: 
                <span class="fw-bold">
                    .csv
                </span>
            </p>
            <script>
                document.getElementById('ImportForm').addEventListener('submit', function(event) {
                    let fileInput = document.getElementById('file');

                    // Confirm before submitting
                    let confirmed = confirm('Vous etes sure que vous voulez importer ces données?');
                    
                    if (!confirmed || fileInput.files.length <= 0) {
                        event.preventDefault(); // Stop form submission if Cancel is clicked
                        return; // Exit the function if Cancel is clicked
                    }

                    if (fileInput.files.length > 0) {
                        let fileName = fileInput.files[0].name;
                        let fileNameWithoutExtension = fileName.split('.').slice(0, -1).join('.').toLowerCase();
                    }
                });

            </script>
        </details>
    @endif

</div>









