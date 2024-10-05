@props(['activeData' , 'page'])

@php
    $nbreCells = 0;
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
            if($page == 'cnss'){
                if($i == 12){
                    $comparisonDate = DateTime::createFromFormat('Y-m-d', $DateDepot->format('Y')+1 . '-1-7');
                }
                else{
                    $comparisonDate = DateTime::createFromFormat('Y-m-d', $DateDepot->format('Y') . '-' . $i+1 . '-7');
                }
            }
            else{
                $comparisonDate = null;
            }
            
            // if($page == 'tvam'){
            //     if($i == 12){
            //         $comparisonDate = DateTime::createFromFormat('Y-m-d', $DateDepot->format('Y')+1 . '-1-7');
            //     }
            //     else{
            //         $comparisonDate = DateTime::createFromFormat('Y-m-d', $DateDepot->format('Y') . '-' . $i+1 . '-7');
            //     }
            // }
        @endphp

        @if(is_null($comparisonDate))
            <td>{{ $activeData->{'date_depot_' . $i} }}</td>
            <td>{{ $activeData->{'num_depot_' . $i} }}</td>
        @else
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
        @endif 

    @else
        <td></td>
        @if($page != 'cnss' && $activeData->{'num_depot_' . $i} == null)
            <td></td>
        @endif
    @endif
@endfor