@props(['activeData' , 'page'])

@php
    $nbreCells = 0;
    $alertsNumber = 0;

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
        {{-- @if ($activeData->annee == $activeData->annee) --}}
            @for($i = 1 ; $i <$nbreCells ; $i++)
                {{-- @if($activeData->{'date_depot_' . $i} == null) --}}
                    @php
                        $DateDepot = new DateTime($activeData->{'date_depot_' . $i});
                        $curentDate = Datetime::createFromFormat('Y-m-d' , Date('Y-n-d'));
                        $thisTrimesterDateDepot = $activeData->{'date_depot_'.ceil(Date('n') / 3)};

                        $ans = $activeData->annee;
                        $year = $activeData->annee;
                        if(Date('n') == 1){
                            $mois = 12;
                        }
                        else{
                            $mois = Date('n')-1;
                        }
                        $thisMonthDateDepot = $activeData->{'date_depot_'.$mois};

                        if ($page === "cnss") {
                            $deadlineDate = (new DateTime("last day of {$ans}-{$mois}"));  
                        }
                        elseif ($page === 'tvam' || $page === 'ir' || $page === 'droittimbre') {
                            $deadlineDate = (new DateTime("last day of {$ans}-{$mois}"))->modify('+20 days');
                        }
                        elseif ($page === 'acompte') {
                                if($i==1){
                                    $year += 1;
                                }
                                if ($i==2) {
                                    $year=$activeData->annee;
                                }
                                if ($i>2) {
                                    $year=$activeData->annee;
                                    $lastMonthTrimester+=3;
                                }
                                if($lastMonthTrimester > 12){
                                    $lastMonthTrimester = 12;
                                }

                                $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-6 days');
                                
                                if($i == 5){
                                    $lastMonthTrimester = 3;
                                }
                            
                        }
                        elseif($page === 'tvat'){

                            if ($i>=2) {
                                $lastMonthTrimester +=3;
                            }
                            if ($lastMonthTrimester > 12) {
                                $lastMonthTrimester = 1;
                                $year+=1;
                            }


                            $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-6 days');

                            if($i == 4){
                                $lastMonthTrimester = 4;
                            }
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

                            if ($activeData->clients->status == 'PM') {
                                $month = 3;    
                            }
                            elseif ($activeData->clients->status == 'PP' || str_starts_with($activeData->clients->status , 'SARL')){
                                $month = 4;
                            }
                            $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');
                        }

                    @endphp

                    @if($page === 'tvam' || $page === 'ir' || $page === 'droittimber' || $page === 'cnss')
                            @if ($thisMonthDateDepot == null && ($curentDate >= $deadlineDate) && Date('n')-1 == $i)
                                @php
                                    $alertsNumber += 1;
                                @endphp
                            @endif  

                    @elseif($page === 'tvat')
                            @php
                                if (Date('n')<=4) {
                                    $nb = ceil(Date('n')/4);
                                }
                                else {
                                    $nb = ceil(Date('n')/3);
                                }
                            @endphp
                            @if ($thisTrimesterDateDepot == null && ($curentDate >= $deadlineDate) && ($nb == $i))
                                @php
                                    $alertsNumber += 1;
                                @endphp
                            @endif  
                    @elseif($page === 'acompte')
                        @php
                            if($i == 1){
                                $nb = 1;
                            }
                            else{
                                $nb = ceil(Date('n') / 3)+1;
                            }
                        @endphp
                        @if ($activeData->{'date_depot_'.$nb} == null && ($curentDate >= $deadlineDate) && ($nb == $i))
                            @php
                                $alertsNumber += 1;
                            @endphp
                        @endif  
                    @else
                            @if($activeData->{'date_depot'} == null && ($curentDate >= $deadlineDate))
                                @php
                                    $alertsNumber += 1;
                                @endphp
                            @endif
                    @endif
                    
                {{-- @endif --}}
            @endfor
        {{-- @endif --}}
    @endforeach
    <div class="d-flex align-items-center justify-content-center gap-1">
        <span class="fw-bold" style="text-transform: capitalize">
            @if ($alertsNumber>0)
                <a href="{{route($page.'.index')}}">
                    @if ($page == 'droittimbre')
                        droit de timbre
                    @else
                        {{$page}}   
                    @endif
                </a>
            @else
                @if ($page == 'droittimbre')
                    droit de timbre
                @else
                    {{$page}}   
                @endif
            @endif
        </span>
        <span class="bg-warning p-2 pt-0 pb-0 fw-bold" style="border-radius: 50%"> {{$alertsNumber}} </span>
    </div>


