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
    <style>
        /* #chart {
            width: 45%;
            /* height: 400px; */
        } */
    </style>
</head>
<body class="p-2">
    <x-menu></x-menu>

    <div class="d-flex justify-content-end mt-3">
        <form action="{{route('stats.index')}}" class="d-flex justify-content-center align-items-center gap-2">
            <input type="text" name="annee" id="" placeholder="Année" value="{{request('annee')}}">
            <button class="btn btn-dark">Appliquer</button>
        </form>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3 mt-3">

        <div style="width: 45%">
            <h4>Taux de respect de délais interne de CNSS</h4>
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
                        categories: ['Janvier', 'Fevrier', 'Mars' , 'Avril' , 'May' , 'Juin' , 'Juillet' , 'Aout' ,'Septembre' , 'Octobre' , 'Nouvembre' , 'Decembre'] // Replace with dynamic labels if needed
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

        {{-- <div style="width: 45%">
            <h4>Taux de respect de délais interne de CNSS</h4>
            <div id="chart2"></div>
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
                        categories: ['Janvier', 'Fevrier', 'Mars' , 'Avril' , 'May' , 'Juin' , 'Juillet' , 'Aout' ,'Septembre' , 'Octobre' , 'Nouvembre' , 'Decembre'] // Replace with dynamic labels if needed
                    },
                    yaxis: {
                        min: 0,
                        max: 100
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart2"), options);
                chart.render();
            </script>
        </div> --}}

    </div>


</body>
</html>