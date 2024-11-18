<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <title>Statistiques</title>
</head>
<body class="p-2">
    <x-menu :users="$users"></x-menu>

    <div class="d-flex justify-content-around mt-5">
        <h3 class="fw-bold">
            <img src="{{asset("imgs/stats.png")}}" alt="statistiques" width="30">
            Taux de respect de délais interne
        </h3>
        <form action="{{route('stats.index')}}" class="d-flex justify-content-center align-items-center gap-2">
            @if (auth()->user()->role == "Admin")
                <select name="userId" class="form-control" style="height: 35px">
                    <option value="">Choisir un collaborateur</option>
                    @foreach ($users as $item)
                        @if (request('userId') == $item->id)
                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                    @endforeach
                </select>
            @endif
            <input type="text" name="annee" class="form-control" id="" placeholder="Année" style="height: 35px" value="{{request('annee')}}">
            <button class="btn btn-dark">Appliquer</button>
            <a href="{{route('stats.index')}}" class="btn btn-danger">Initialiser</a>
        </form>
    </div>
    <hr>

    <details class="bg-body-secondary p-2 m-2 rounded">
        <summary class="fw-bold fs-5">
           Déclarations mensuelle:
        </summary>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 flex-wrap">
    
            <div style="width: 45%">
                <h4>CNSS</h4>
                <div id="chart1"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Cnss) !!}
                        }],
                        xaxis: {
                            categories: ['Janvier', 'Fevrier', 'Mars' , 'Avril' , 'Mai' , 'Juin' , 'Juillet' , 'Aout' ,'Septembre' , 'Octobre' , 'Nouvembre' , 'Decembre'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart1"), options);
                    chart.render();
                </script>
            </div>
    
            <div style="width: 45%">
                <h4>Tva-M</h4>
                <div id="chart2"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Tvam) !!}
                        }],
                        xaxis: {
                            categories: ['Janvier', 'Fevrier', 'Mars' , 'Avril' , 'Mai' , 'Juin' , 'Juillet' , 'Aout' ,'Septembre' , 'Octobre' , 'Nouvembre' , 'Decembre'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart2"), options);
                    chart.render();
                </script>
            </div>
        
            <div style="width: 45%">
                <h4>IR</h4>
                <div id="chart3"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Ir) !!}
                        }],
                        xaxis: {
                            categories: ['Janvier', 'Fevrier', 'Mars' , 'Avril' , 'Mai' , 'Juin' , 'Juillet' , 'Aout' ,'Septembre' , 'Octobre' , 'Nouvembre' , 'Decembre'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart3"), options);
                    chart.render();
                </script>
            </div>
    
            <div style="width: 45%">
                <h4>Droit de timbre</h4>
                <div id="chart4"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Droittimber) !!}
                        }],
                        xaxis: {
                            categories: ['Janvier', 'Fevrier', 'Mars' , 'Avril' , 'Mi' , 'Juin' , 'Juillet' , 'Aout' ,'Septembre' , 'Octobre' , 'Nouvembre' , 'Decembre'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart4"), options);
                    chart.render();
                </script>
            </div>
    
        </div>
    </details>

    <details class="bg-body-secondary p-2 m-2 rounded">
        <summary class="fw-bold fs-5">
           Déclarations trimistrielle:
        </summary>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 flex-wrap">
    
            <div style="width: 45%">
                <h4>Acompte</h4>
                <div id="chart5"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Acompte) !!}
                        }],
                        xaxis: {
                            categories: ['Regularisation', 'Trimestre 1', 'Trimestre 2' , 'Trimestre 3' , 'Trimestre 4'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart5"), options);
                    chart.render();
                </script>
            </div>
    
            <div style="width: 45%">
                <h4>Tva-T</h4>
                <div id="chart6"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Tvat) !!}
                        }],
                        xaxis: {
                            categories: ['Trimestre 1', 'Trimestre 2' , 'Trimestre 3' , 'Trimestre 4'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart6"), options);
                    chart.render();
                </script>
            </div>
    
        </div>
    </details>

    <details class="bg-body-secondary p-2 m-2 rounded">
        <summary class="fw-bold fs-5">
           Déclarations Annuelle:
        </summary>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 flex-wrap">
            
            <div style="width: 45%">
                <h4>Etat/TP/CM/IRPROF/PV</h4>
                <div id="chart7"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($others) !!}
                        }],
                        xaxis: {
                            categories: ['Etat 9421', 'TP' , 'CM' , 'IrProf' , 'PV'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart7"), options);
                    chart.render();
                </script>
            </div>

            <div style="width: 45%">
                <h4>Bilan</h4>
                <div id="chart8"></div>
                <script>
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Pourcentage %',
                            data: {!! json_encode($Bilan) !!}
                        }],
                        xaxis: {
                            categories: ['Persone physique', 'Persone morale'] // Replace with dynamic labels if needed
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    };
    
                    var chart = new ApexCharts(document.querySelector("#chart8"), options);
                    chart.render();
                </script>
            </div>
        </div>
    </details>
</body>
</html>