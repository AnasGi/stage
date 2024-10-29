@props(['page' , 'activeData' , 'users'])

<style>
    

    .tools {
        padding: 10px;
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

    .searchForm input , .searchForm select {
        height: 30px;
        padding: 0px 5px
    }

    @media screen and (max-width: 1100px) {
        .tools:first-child {
            width: 60% !important;
        }
        .tools:last-child {
            width: 39% !important;
        }
    }
</style>

<div class="d-flex gap-2 align-items-start mt-3 mb-2">
    <details class="tools" style="width: 70%" open>
        <summary>Rechercher par</summary>    
        <form action="{{route($page.'.index')}}" class="pb-0">
            <div class="searchForm d-flex gap-2 flex-wrap" style="margin-bottom: 11px">
                <div>
                    <input type="text" name="annee" id="" value="{{ request('annee') }}" placeholder="Année">
                </div>

                @if($page == 'clients')
                    <div>
                        <input type="text" name="mois" id="" value="{{ request('mois') }}" placeholder="Mois">
                    </div>
                @endif

                <div>
                    <input list="liste-clients-1" name="code" value="{{ request('code') }}" placeholder="Code de client:">
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
                        <input type="date" name="date" id="" value="{{ request('date') }}" placeholder="Date de depot"/>
                    </div>
                @endif

                @if (auth()->user()->role == 'Admin')
                    <div>
                        <select name="name" id="">
                            <option value="">Collaborateur</option>
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
            </div>
            <div class="d-flex gap-2 align-items-start">
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
        <details class="tools" style="width: 30%" open>
            <summary>Importer des données Excel</summary>    
            <form action="{{ route($page.'.import') }}" method="POST" enctype="multipart/form-data" id="ImportForm" >
                @csrf
                <div class="d-flex align-items-center flex-wrap">
                    <input class="w-75" type="file" name="file" id="file" accept=".csv">
                    <button type="submit" class="btn btn-dark w-25" style="padding: 3px 10px">Importer</button>
                </div>
            </form>
            <p id="ImportError" class="alert alert-danger m-0 p-1">Choisir un fichier nomé: 
                <span class="fw-bold">
                    {{$page}}.csv
                </span>
            </p>
            <script>
                document.getElementById('ImportForm').addEventListener('submit', function(event) {
                    let fileInput = document.getElementById('file');
                    let errorMessage = document.getElementById('ImportError');

                    // Confirm before submitting
                    let confirmed = confirm('Vous etes sure que vous voulez importer ces données?');
                    
                    if (!confirmed) {
                        event.preventDefault(); // Stop form submission if Cancel is clicked
                        return; // Exit the function if Cancel is clicked
                    }

                    // Safely pass PHP variable to JavaScript
                    let page = <?php echo json_encode($page); ?>;

                    if (fileInput.files.length > 0) {
                        let fileName = fileInput.files[0].name;
                        let fileNameWithoutExtension = fileName.split('.').slice(0, -1).join('.').toLowerCase();

                        console.log(fileName);
                        console.log(fileNameWithoutExtension);
                        console.log(page);

                        // Check if the file name (without extension) matches the expected page name
                        if (fileNameWithoutExtension !== page) {
                            event.preventDefault();  // Prevent form submission if the file name is incorrect
                            errorMessage.textContent = 'Le nom du fichier doit être ' + page + ".csv";
                        } else {
                            errorMessage.textContent = ''; // Clear any previous error message
                        }
                    }
                });

            </script>
        </details>
    @endif

</div>









