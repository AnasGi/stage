@props(['page' , 'activeData' , 'users'])

<style>
    .searchForm label{
        display: inline-block;
        width: 150px;
    }
    .searchForm div{
        margin-bottom: 10px
    }

    .tools {
        margin: 20px 0px;
        padding: 10px 8px;
        background-color: rgba(228, 228, 228, 0.812);
        width: 30%;
    }

    .tools form  {
        margin-top: 20px;
    }
</style>

<details class="tools shadow">
        <summary>Importer des données Excel</summary>    
        <form action="{{ route($page.'.import') }}" method="POST" enctype="multipart/form-data" id="ImportForm">
            @csrf
            <div>
                <label for="file">Upload CSV File:</label>
                <input type="file" name="file" id="file" accept=".csv">
            </div>
            <div>
                <button type="submit" class="btn btn-dark mt-3">Importer les données {{$page}}</button>
            </div>
            <p id="ImportError" class="text-danger"></p>
        </form>
</details>
<script>
        document.getElementById('ImportForm').addEventListener('submit', function(event) {
            let fileInput = document.getElementById('file');
            let errorMessage = document.getElementById('ImportError');

            confirm('Vous etes sure que vous voulez importer ces données?')
            
            // Safely pass PHP variable to JavaScript
            let page = <?php echo json_encode($page); ?>;

            if (fileInput.files.length > 0) {
                let fileName = fileInput.files[0].name;
                let fileNameWithoutExtension = fileName.split('.').slice(0, -1).join('.').toLowerCase();

                console.log(fileName);
                console.log(fileNameWithoutExtension);
                console.log(page);
                
                if (fileNameWithoutExtension !== page) {
                    event.preventDefault();  // Prevent form submission
                    errorMessage.textContent = 'Le nom du fichier doit etre ' + page + ".csv";
                } else {
                    errorMessage.textContent = ''; // Clear error message
                }
            }
        });
</script>
<details class="tools shadow">
        <summary>Rechercher par</summary>    
        <form action="{{route($page.'.index')}}" class="searchForm">
            @if($page != 'clients')
                <div>
                    <label for="">
                        Année:
                    </label>
                    <input type="text" name="annee" id="" value="{{ request('annee') ?? Date('Y') }}">
                </div>
            @endif

            <div>
                <label for="">
                    Code de client:
                </label>
                <input list="clients-list" name="code" id="code" value="{{ request('code') }}">
                <datalist id="clients-list">
                    @if($page != 'clients')
                        @foreach ($activeData as $data)
                            <option value="{{$data->clients->code}}">{{$data->clients->nom}}</option>
                        @endforeach
                    @else
                        @foreach ($activeData as $data)
                            <option value="{{$data->code}}">{{$data->nom}}</option>
                        @endforeach
                    @endif
                </datalist> 
            </div>

            @if ($page == 'etat' || $page == 'bilan' || $page == 'cm' || $page == 'tp' || $page == 'irprof' || $page == 'pv')
                <div>
                    <label for="">Date de depot</label>
                    <input type="date" name="date" id="" value="{{ request('date') }}"/>
                </div>
            @endif

            @if (auth()->user()->role == 'Admin')
                <div>
                    <label for="">Responsable:</label>
                    <select name="name" id="">
                        <option value=""></option>
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
                
            <button class="btn btn-primary mb-3">Rechercher</button>
        </form>
</details>
<details class="tools shadow">
    <summary>Statistique</summary>
    <div class="mt-3">
        <p class="fw-bold">Nombre des données:
            <span class="bg-info rounded p-2 pt-0 pb-0 m-2">
                {{count($activeData)}}
            </span> 
        </p>
    </div>
</details>
<hr class="w-25">




