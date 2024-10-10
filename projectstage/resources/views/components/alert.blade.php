@props(['activeData' , 'page'])

@php
    $nbreCells = 0;
    $alertsNumber = 0;
    $mois = "";
    $trimestre = "";
    $year = (int)Date('Y');

    if($page === 'acompte'){
        $lastMonthTrimester = 3;
    }
    elseif ($page === 'tvat') {
        $lastMonthTrimester = 4;
    }
@endphp

@if($page == 'tvat')
    {{-- for tvat --}}
    @php $nbreCells = 5; @endphp 

@elseif($page == 'acompte')
    {{-- for acompte --}}
    @php $nbreCells = 6; @endphp

@elseif($page === 'tvam' || $page === 'ir' || $page === 'droittimbre' || $page === 'cnss')
    {{-- for mensuelle --}}
    @php $nbreCells = 13; @endphp
@else
    @php $nbreCells = 2; @endphp
@endif

@foreach ($activeData as $activeData)
    @if ($activeData->annee == Date('Y'))
        @for($i = 1 ; $i <$nbreCells ; $i++)
            @if($activeData->{'date_depot_' . $i} == null)
                @php
                    $DateDepot = new DateTime($activeData->{'date_depot_' . $i});
                    $curentDate = Datetime::createFromFormat('Y-m-d' , Date('Y-n-d'));
                    $thisMonthDateDepot = $activeData->{'date_depot_'.Date('n')};

                    $lastDayNextMonth = (new DateTime('last day of next month'));

                    if ($page === "cnss") {
                        $deadlineDate = $lastDayNextMonth->modify('-26 days');  
                    }
                    elseif ($page === 'tvam' || $page === 'ir' || $page === 'droittimbre') {
                        $deadlineDate = $lastDayNextMonth->modify('-6 days');
                    }
                    elseif ($page === 'acompte') {
                        if($lastMonthTrimester <= 12){
                            if($i==1){
                                $year += 1;
                            }
                            elseif ($i==2) {
                                $lastMonthTrimester+=3;
                            }

                            $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-3 days');
                        }
                    }
                    elseif($page === 'tvat'){
                        if ($lastMonthTrimester > 12) {
                            $lastMonthTrimester = 1;
                            $year+=1;
                        }
                        
                        if ($i===2) {
                            $lastMonthTrimester +=3;
                        }

                        $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-3 days');
                    }
                    elseif ($page === 'etat') {
                        $year +=1;
                        $month = 2;
                        $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');
                    }
                    elseif ($page === 'tp' || $page === 'cm') {
                        $year +=1;
                        $month = 1;
                        $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');

                    }
                    elseif ($page === 'irprof') {
                        $year +=1;
                        $month = 4;
                        $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');

                    }
                    elseif ($page === 'pv') {
                        $year +=1;
                        $month = 7;
                        $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');

                    }
                    elseif ($page === 'bilan') {
                        $year +=1;
                        $month = 0;

                        if (str_ends_with($activeData->clients->status , 'Morale')) {
                            $month = 3;    
                        }
                        elseif (str_ends_with($activeData->clients->status , 'Physique')){
                            $month = 4;
                        }
                        $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');
                    }

                @endphp

                @if($page === 'tvam' || $page === 'ir' || $page === 'droittimber' || $page === 'cnss')
                        @if ($thisMonthDateDepot == null && ($curentDate >= $deadlineDate) && Date('n') == $i)
                            @php
                                $alertsNumber += 1;
                                $mois = $i;
                            @endphp
                        @endif  

                @elseif($page === 'acompte' || $page === 'tvat')
                        @if ($thisMonthDateDepot == null && ($curentDate >= $deadlineDate) && (Date('n') > $lastMonthTrimester && Date('n') < $lastMonthTrimester+3))
                            @php
                                $alertsNumber += 1;
                                $trimestre = $i;
                            @endphp
                        @endif  

                @else
                        @if($thisMonthDateDepot == null && ($curentDate >= $deadlineDate))
                            @php
                                $alertsNumber += 1;
                            @endphp
                        @endif
                @endif
                
            @endif
        @endfor
    @endif
@endforeach


@if($alertsNumber != 0)
    <p class="alert alert-warning fw-bold ">

        @if(!empty($mois))
            If faut saisir la date de depot du mois {{$mois}}! 
        @elseif(!empty($trimestre))
            If faut saisir la date de depot du Trimestre actuelle! 
        @else
            If faut saisir la date de depot ! 
        @endif

        <span class="bg-secondary p-2 pt-0 pb-0 text-white rounded"> {{$alertsNumber}} </span>
    </p>
@endif

