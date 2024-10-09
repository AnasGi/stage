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
                if($tri <= 12){

                    if($i==1){
                        $annee += 1;
                    }
                    elseif ($i===2) {
                        $tri += 3;
                    }

                    $comparisonDate = (new DateTime("last day of {$annee}-{$tri}"))->modify('-3 days');
                }

            }
            elseif($page === 'tvat'){

                if ($tri>12) {
                    $tri = 1;
                    $annee+=1;
                }

                if ($i===2) {
                    $tri += 3;
                }


                $comparisonDate = (new DateTime("last day of {$annee}-{$tri}"))->modify('-3 days');
            }
            
        @endphp

        @if($DateDepot > $comparisonDate)
            <td class="bg-danger">{{ $activeData->{'date_depot_' . $i} }}</td>
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
                $thisMonthDateDepot = $activeData->{'date_depot_'.Date('n')};

                if ($page === "cnss") {
                    $deadlineDate = (new DateTime('first day of next month'))->modify('+4 days');  
                }
                elseif ($page === 'tvam' || $page === 'ir' || $page === 'droittimbre') {
                    $deadlineDate = (new DateTime('last day of next month'))->modify('-6 days');
                }
                elseif ($page === 'acompte') {

                    if($lastMonthTrimester < 12){
                        if($i==1){
                            $year += 1;
                        }
                        elseif ($i===2) {
                            $lastMonthTrimester += 3;
                        }
        
                        $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-6 days');
                    }

                }
                elseif($page === 'tvat'){

                    if ($lastMonthTrimester>12) {

                        $lastMonthTrimester = 1;
                        $year+=1;

                    }

                    if ($i===2) {
                        $lastMonthTrimester += 3;
                    }

                    $deadlineDate = (new DateTime("last day of {$year}-{$lastMonthTrimester}"))->modify('-6 days');
                }
            @endphp

            @if($page === 'tvam' || $page === 'ir' || $page === 'droittimbre' || $page === 'cnss')

                @if ($thisMonthDateDepot == null && ($curentDate >= $deadlineDate) && Date('n') == $i)
                    <td class="bg-warning"></td>
                @else
                    <td></td>
                @endif

            @elseif($page === 'acompte' || $page === 'tvat')

                @if($thisMonthDateDepot == null && ($curentDate >= $deadlineDate) && (Date('n') < $lastMonthTrimester))
                    <td class="bg-warning"></td>
                @else
                    <td></td>
                @endif

            @else
                @if($thisMonthDateDepot == null && ($curentDate >= $deadlineDate))
                    <td class="bg-warning"></td>
                @else
                    <td></td>
                @endif
            @endif  
            
        @else
            <td></td>
        @endif

        @if($page != 'cnss' && $activeData->{'num_depot_' . $i} == null)
            <td></td>
        @endif
    @endif
@endfor



