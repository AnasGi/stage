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

    .excel{
        position: fixed;
        bottom: 17%;
        right: 15%;
        display: flex;
        align-items: center;
        gap: 5px;
        z-index: 2;
    }
    .excelLogo {
        border-radius: 50%;
    }
    .excelLogo img {
        width: 40px;
        background-color: #D0ECE7;
        border-radius: 50%;
        padding: 3px;
        cursor: pointer;
        box-shadow: 3px 3px 5px #818181;
    }
    .excelForm {
        background-color: #D0ECE7;
        visibility: hidden;
        padding: 10px;
        border-radius: 10px;
        order: -1;
        box-shadow: 3px 3px 5px #818181;
    }
</style>

<div class="filtercont d-flex gap-2 align-items-center mt-4 mb-2 w-100">
    <div class="filterparam">
        <div style="text-transform: uppercase ; width:200px" class="fw-bold d-flex gap-2 align-items-center">
            <img src="{{asset('imgs/filter.png')}}" alt="Rechercher" width="20">
            <span>
                Recherche par
            </span>
        </div>   
        <form action="{{route($page.'.index')}}" class="pb-0 w-100">
                <div class="searchForm d-flex gap-2 align-items-center">
                    <div>
                        <input type="text" name="annee" class="form-control" id="" value="{{ request('annee') }}" placeholder="Année">
                    </div>
    
                    @if($page == 'clients')
                        <div>
                            <input type="text" name="mois" class="form-control" id="" value="{{ request('mois') }}" placeholder="Mois">
                        </div>
                        <div>
                            <select name="sort" id="" class="form-control">
                                <option value="">Trier par</option>
                                <option value="DateSort" {{ request('sort') == 'DateSort' ? "selected" : "" }}>Date de création</option>
                                <option value="CodeSort" {{ request('sort') == 'CodeSort' ? "selected" : "" }}>Code de client</option>
                            </select>
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
                                <option value="">Tous les collaborateurs</option>
                                @foreach ($users as $user)
                                    @if($user->id == request('name'))
                                        <option selected value="{{$user->id}}">{{$user->name}}</option>
                                    @else
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div>
                        <button class="btn btn-primary p-3 pt-1 pb-1" >Filtrer</button>
                    </div>
                    <div>
                        <a href="{{route($page.'.index')}}" class="btn btn-danger p-3 pt-1 pb-1">Initialiser</a>
                    </div>
                </div>
        </form>   
    </div>
</div>
    
@if (auth()->user()->role == 'Admin' && $page == 'clients')
    <div class="excel">
            <div class="excelLogo">
                <img src="{{asset('imgs/excel.png')}}" alt="excel import" onclick="openExcelForm()">
            </div>
            <div class="excelForm" id="excelForm">
                <form action="{{ route($page.'.import') }}" method="POST" enctype="multipart/form-data" id="ImportForm" >
                    @csrf
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <input class="w-50" type="file" name="file" id="file" accept=".csv"  class="form-control">
                        <div>
                            <button type="submit" class="btn btn-dark fw-bold" style="padding: 3px 5px ; font-size:14px">Importer</button>
                            <button type="button" class="btn btn-danger fw-bold" onclick="closeExcelForm()" style="padding: 3px 5px ; font-size:14px">Fermer</button>
                        </div>
                    </div>
                </form>
                <p id="ImportError" class="alert alert-danger mt-1 mb-1 p-2">Choisir un fichier avec éxtension: 
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
    
                    function openExcelForm(){
                        document.getElementById('excelForm').style.visibility = "visible"; 
                    }
                    function closeExcelForm(){
                        document.getElementById('excelForm').style.visibility = "hidden"; 
                    }
                </script>
            </div>
    </div>
@endif








