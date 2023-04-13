
<div class="pull-left" style="margin-top: 18px;">
    <div class="btn-group">
        <div class="btn-group" id="dropdown-paginate-limit">
            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">{{isset($_GET['limit']) && $_GET['limit'] == 30 ? '表示 1-30 の '.$results->total().'&nbsp;' : (isset($_GET['limit']) && $_GET['limit'] == 50 ? '表示 1-50 の '.$results->total().'&nbsp;' : (isset($_GET['limit']) && $_GET['limit'] == 100 ? '表示 1-100  の '.$results->total().'&nbsp;' : '表示 1-'.$results->count().' の '.$results->total().'&nbsp;'))}}<span class="caret"></span> </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" data-value = "30" >表示 1-30</a>
                </li>
                <li><a href="javascript:void(0)" data-value = "50" >表示 1-50</a>
                </li>
                <li><a href="javascript:void(0)" data-value = "100" >表示 1-100</a>
                </li>
            </ul>
        </div>
    </div>
    {{--
        表示 1-{{$results->count()}} の {{$results->total()}}
        Show page {{$results->currentPage()}}/{{$results->lastPage()}} with {{ $results->perPage() }} {{$object}} in total {{ $results->total() }} {{$object}}  
    --}}
</div>
<div class="pull-right pagination dataTables_paginate" style="margin-top: 0px;margin-bottom: -20px;">
    <ul class="pagination">
    @if ($results->lastPage() > 1)
	    <?php
	        $start = $results->currentPage() - 3; // show 3 pagination links before current
	        $end = $results->currentPage() + 3; // show 3 pagination links after current
	        if($start < 1) $start = 1; // reset start to 1
	        if($end >= $results->lastPage() ) $end = $results->lastPage(); // reset end to last page
	    ?>
        <li class="{{ $results->currentPage() == 1 ? 'disabled' : ''}}"><a href="{{ $results->url(1) }}">&laquo;</a></li>
        @if($start>1)
	        <li><a href="{{ $results->url(1) }}">{{1}}</a> <a href="javascript:void(0)">...</a></li>
	    @endif
       @for ($i = $start; $i <= $end; $i++)
            <li class="{{ $i == $results->currentPage() ? 'active' : ''}}"><a href="{{$results->url($i)}}">{{$i}}</a></li>
        @endfor()
        @if($end<$results->lastPage())
        	<li><a href="javascript:void(0)">...</a> <a href="{{ $results->url($results->lastPage()) }}">{{$results->lastPage()}}</a></li>
	    @endif
        <li class="{{ $results->currentPage() == $results->lastPage() ? 'disabled' : ''}}"><a href="{{ $results->url($results->currentPage()+1) }}">&raquo;</a></li>
    @endif
    </ul>
</div>
