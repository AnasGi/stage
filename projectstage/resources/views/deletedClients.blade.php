<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Clients supprimés</title>
    <style>
        @media screen and (max-width: 1100px) {
            .detailCont{
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="p-2">
    <x-menu :users="$users"></x-menu>
    <div class="d-flex justify-content-center ">
        <div class="w-75 detailCont">
            <div class="d-flex justify-content-between align-items-center bg-white shadow rounded p-3 mt-3 mb-3">
                <h3 class="m-0">
                    Les clients supprimés 
                    <span class="bg-info rounded p-3 pt-1 pb-1 fs-4">{{count($deletedClients)}}</span>
                </h3>
                <a href="{{route('clients.deletedTable')}}" class="btn btn-dark" style="font-size: 12px">Sous form d'un tableau</a>
            </div>
            @if(session('success'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </p>
            @endif
            <div class="d-flex">
                <div class="w-75 detailCont">
                    @foreach ($deletedClients as $client)
                        <details class="m-4 mt-0 mb-0">
                            <summary class="bg-body-secondary mt-2 rounded p-2 d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2 align-items-center w-75">
                                    <span class="w-75">
                                        {{$client->nom}}
                                    </span>
                                    <span
                                        class="btn btn-secondary p-1 w-25" 
                                        style="font-size: 12px" 
                                    >
                                        {{$client->deleted_at->format('d/m/Y')}}
                                    </span>
                                    <span
                                        class="btn btn-danger p-1 w-25" 
                                        style="font-size: 12px" 
                                    >
                                        {{$client->deletetype}}
                                    </span>
                                </div>
                                <span>
                                    <a 
                                        class="btn btn-success" 
                                        style="font-size: 13px" 
                                        href="{{route('clients.restore' , $client->id)}}" 
                                        onclick="return confirm('Est-ce-que vous etes sure de restorer ce client?')"
                                    >
                                        Restorer
                                    </a>
                                </span>
                            </summary>
                            <ul>
                                @if ($client->motif || $client->motifdoc)
                                    <li style="list-style-type: none ; border-left:3px solid red; padding:5px 0px 5px 5px" class="mb-1">
                                        <div class="d-flex gap-2 align-items-center flex-wrap bg-body-secondary p-1 pt-2 pb-2 rounded">
                                            @if ($client->motif)
                                                <span class="fw-bold">
                                                    {{$client->motif}}
                                                </span>
                                            @endif
                                            @if($client->motifdoc)
                                                <span>
                                                    <a href="{{ Storage::url($client->motifdoc) }}" download>Télécharger Document</a>
                                                </span>
                                            @endif

                                        </div>
                                    </li>
                                @else
                                    <li style="list-style-type: none ; border-left:3px solid red; padding:5px 0px 5px 5px" class="mb-1" >
                                        <form action="{{ route('clients.motif', $client->id) }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center flex-wrap bg-body-secondary p-1 pt-2 pb-2 rounded">
                                            @csrf 
                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="text" name="motif" placeholder="Motif">
                                                <input type="file" name="motifdoc">
                                            </div>
                                            <button>Affecter</button>
                                        </form>                                    
                                    </li>
                                @endif
                                <li class="fw-bold">Code: {{$client->code}}</li>
                                <li class="fw-bold">Adresse: {{$client->adresse}}</li>
                                <li class="fw-bold">Activite: {{$client->activite}}</li>
                                <li class="fw-bold">collaborateur: {{$client->users->name}}</li>
                            </ul>
                        </details>
                    @endforeach
                </div>
        
            </div>
        </div>
    </div>
</body>
</html>