<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <title>Statistiques</title>
</head>
<body class="p-2">
    <x-menu :users="$users"></x-menu>

    <div class="d-flex justify-content-end mt-3">
        <form action="{{route('stats.index')}}" class="d-flex justify-content-center align-items-center gap-2">
            <select name="userId" class="p-1">
                <option value="">Choisir un collaborateur</option>
                @foreach ($users as $item)
                    @if (request('userId') == $item->id)
                        <option value="{{$item->id}}" selected>{{$item->name}}</option>
                    @else
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endif
                @endforeach
            </select>
            <input type="text" name="annee" id="" placeholder="Année" value="{{request('annee')}}">
            <button class="btn btn-dark">Appliquer</button>
        </form>
    </div>

    <h3 class="text-center">Taux de respect de délais interne</h3>

    <details>
        <summary class="fw-bold fs-3">
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

    <hr>

    <details>
        <summary class="fw-bold fs-3">
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

    <hr>

    <details>
        <summary class="fw-bold fs-3">
           Déclarations Annuelle:
        </summary>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 flex-wrap">
            
            <div style="width: 45%">
                <h4>Etat/IRPROF/CM/PV/TP</h4>
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