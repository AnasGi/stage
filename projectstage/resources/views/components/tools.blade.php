@props(['page' , 'activeData' , 'users'])

<form action="{{ route($page.'.import') }}" method="POST" enctype="multipart/form-data" id="ImportForm">
    @csrf
    <div>
        <label for="file">Upload CSV File:</label>
        <input type="file" name="file" id="file" accept=".csv">
    </div>
    <div>
        <button type="submit">Importer les données {{$page}}</button>
    </div>
    <p id="ImportError" class="text-danger"></p>
</form>
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

<form action="{{route($page.'.index')}}">
    @if($page != 'clients')
        <label for="">
            Filtrer par année
        </label>
        <input type="text" name="annee" id="" value="{{ request('annee') ?? Date('Y') }}">
    @endif
    <br>
    <label for="">Rechercher par code de client</label>
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
    <br>
    @if ($page == 'etat' || $page == 'bilan' || $page == 'cm' || $page == 'tp' || $page == 'irprof' || $page == 'pv')
            <label for="">Rechercher par date de depot</label>
            <input type="date" name="date" id="" value="{{ request('date') }}"/>
    @endif
    <br>
    @if (auth()->user()->role == 'Admin')
            <label for="">Rechercher par responsable</label>
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
    @endif
    <br>
        
    <button class="btn btn-primary">Filtrer</button>
</form>



