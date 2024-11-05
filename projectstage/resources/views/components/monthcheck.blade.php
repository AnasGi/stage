@props(['activeData' , 'page'])

@php
    $nbreCells = 0;

    if($page === 'acompte'){
        $lastMonthTrimester = 3;
        $tri = 3;
    }
    elseif ($page === 'tvat') {
        $lastMonthTrimester = 4;
        $tri = 4;
    }

    $year = (int)Date('Y');

@endphp

@if($page == 'tvat')
    {{-- for tvat --}}
    @php $nbreCells = 5; @endphp 

@elseif($page == 'acompte')
    {{-- for acompte --}}
    @php $nbreCells = 6; @endphp

@else
    {{-- for mensuelle --}}
    @php $nbreCells = 13; @endphp
@endif

<style>
    .custom-title {
        cursor: pointer;
        position: relative;
    }

    .motif {
        position: absolute ;
        background-color: #ffffff;
        color: #a21f1f;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        font-size: 12px;
        z-index: 1;
    }

    .custom-title:hover {
        background-color: #f47777 !important;
    }

    .custom-title:hover div {
        opacity: 1;
    }

</style>


@for($i = 1 ; $i <$nbreCells ; $i++)

    @if($activeData->{'date_depot_' . $i} != null)
        @php 
            $DateDepot = new DateTime($activeData->{'date_depot_' . $i});
            $annee = $activeData->annee;
            $month = $i+1;

            if($month == 13){
                $month = 1;
                $annee +=1;
            }

            if ($page === 'cnss') {
                $comparisonDate = (new DateTime("first day of {$annee}-{$month}"))->modify('+6 days');
            }
            elseif($page === 'tvam' || $page === 'ir' || $page === 'droittimbre'){
                $comparisonDate = (new DateTime("last day of {$annee}-{$month}"))->modify('-3 days');
            }
            elseif ($page === 'acompte') {

                    if($i==1){
                        $annee += 1;
                    }
                    if ($i==2) {
                        $annee = $activeData->annee;
                    }
                    if ($i>2) {
                        $annee = $activeData->annee;
                        $tri += 3;
                    }

                    $comparisonDate = (new DateTime("last day of {$annee}-{$tri}"))->modify('-3 days');
                

            }
            elseif($page === 'tvat'){

                if ($i>=2) {
                    $tri += 3;
                }
                if ($tri >= 12) {
                    $tri = 1;
                    $annee+=1;
                }   
                
                $comparisonDate = (new DateTime("last day of {$annee}-{$tri}"))->modify('-3 days');
            }
            
        @endphp

        @if($DateDepot > $comparisonDate)
            <td class="bg-danger custom-title">
                {{ $activeData->{'date_depot_' . $i} }}
                <div class="motif d-flex align-items-center gap-2">
                    @if ($activeData->{'motif_' . $i})
                        <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                        {{ $activeData->{'motif_' . $i} }}
                    @else
                        Aucun motif
                    @endif
                </div>
            </td>
            @if($page != 'cnss')
                <td>{{ $activeData->{'num_depot_' . $i} }}</td>
            @endif
        @else
            <td>{{ $activeData->{'date_depot_' . $i} }}</td>
            @if($page != 'cnss')
                <td>{{ $activeData->{'num_depot_' . $i} }}</td>
            @endif
        @endif
    @else
        @if($activeData->annee == Date('Y'))
            @php

                $curentDate = Datetime::createFromFormat('Y-m-d' , Date('Y-n-d'));
                $thisTrimesterDateDepot = $activeData->{'date_depot_'.ceil(Date('n') / 3)};

                $ans = Date('Y');
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
                            $year=Date('Y');
                        }
                        if ($i>2) {
                            $year=Date('Y');
                            $lastMonthTrimester += 3;
                        }
        
                        $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-3 days');
                    

                }
                elseif($page === 'tvat'){

                    if ($i>=2) {
                        $lastMonthTrimester += 3;
                    }
                    if ($lastMonthTrimester > 12) {
                        $lastMonthTrimester = 1;
                        $year+=1;

                    }


                    $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-3 days');
                }
            @endphp

            @if($page === 'tvam' || $page === 'ir' || $page === 'droittimbre' || $page === 'cnss')

                @if ($thisMonthDateDepot == null && ($curentDate >= $deadlineDate) && Date('n')-1 == $i)
                    <td class="bg-warning"></td>
                @else
                    <td class="bg-body-secondary custom-title">
                        <div class="motif d-flex align-items-center gap-2">
                            @if ($activeData->{'motif_' . $i})
                                <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                                {{ $activeData->{'motif_' . $i} }}
                            @else
                                Aucun motif
                            @endif
                        </div>
                    </td>
                @endif

            @elseif($page === 'tvat')

                @if($thisTrimesterDateDepot == null && ($curentDate >= $deadlineDate) && (ceil(Date('n')/3) == $i))
                    <td class="bg-warning"></td>
                @else
                    <td class="bg-body-secondary custom-title">
                        <div class="motif d-flex align-items-center gap-2">
                            @if ($activeData->{'motif_' . $i})
                                <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                                {{ $activeData->{'motif_' . $i} }}
                            @else
                                Aucun motif
                            @endif
                        </div>
                    </td>
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
                @if($activeData->{'date_depot_'.$nb} == null && ($curentDate >= $deadlineDate) && ($nb == $i))
                    <td class="bg-warning"></td>
                @else
                    <td class="bg-body-secondary custom-title">
                        <div class="motif d-flex align-items-center gap-2">
                            @if ($activeData->{'motif_' . $i})
                                <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                                {{ $activeData->{'motif_' . $i} }}
                            @else
                                Aucun motif
                            @endif
                        </div>
                    </td>
                @endif

            @else
                @if($thisMonthDateDepot == null && ($curentDate >= $deadlineDate))
                    <td class="bg-warning"></td>
                @else
                    <td class="bg-body-secondary custom-title">
                        <div class="motif d-flex align-items-center gap-2">
                            @if ($activeData->{'motif_' . $i})
                                <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                                {{ $activeData->{'motif_' . $i} }}
                            @else
                                Aucun motif
                            @endif
                        </div>
                    </td>
                @endif
            @endif  
        @else
            <td class="bg-body-secondary"></td>
        @endif

        @if($page != 'cnss' && $activeData->{'num_depot_' . $i} == null)
            <td></td>
        @endif
    @endif
@endfor



