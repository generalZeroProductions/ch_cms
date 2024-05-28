




@php
    $index = 0;
    $ogIndex = $recordsIndex;
    $records = $allRecords->slice($recordsIndex, 10);
    $displayStart = $ogIndex + 1;
    $displayEnd = 0;
    $onDisplay = $ogIndex + count($records);

@endphp

@foreach ($records as $record)
    @php
        $date = $record->created_at->format('Y-m-d');
    @endphp

    <div class="row center-paginate" style="background-color:#ced8e3;" id="contact_paginate{{ $record->id }}">
        <div class="col-md-4">
            <p>{{ $date }}</p>
        </div>
        <div class="col-md-4">
            <p>{{ $record->name }}</p>
        </div>
        <div class="col-md-2" style="text-align:center">
            @if ($record->read)
                <button onClick="showInquiry('{{ $record->id }}')" class="btn btn-secondary" style="margin-top:4px" id="showInquiry_btn{{ $record->id }}">
                    <img src="{{ asset('icons/glasses_white.svg') }}" id="read_contact{{ $record->id }}" style="height:18px">
                </button>
            @else
                <form id="mark_contact_read_{{ $record->id }}" style="display:none">
                    @csrf
                    <input type="hidden" name="form_name" value="mark_contact_read_{{ $record->id }}">
                    <input type="hidden" name="inq_id" value="{{ $record->id }}">
                </form>
                <button onClick="markContactRead('{{ $record->id }}')" id="showInquiry_btn{{ $record->id }}" class="btn btn-warning" style="margin-top:4px">
                    <img src="{{ asset('icons/glasses.svg') }}" style="height:18px" id="read_contact{{ $record->id }}">
                </button>
            @endif
        </div>
        <div class="col-md-2" style="text-align:center">
            <button class="btn btn-danger" style="margin-top:4px" onClick="openMainModal('deleteInquiry', '{{$record->id }}', '.modal-sm')">
                <img src="{{ asset('icons/trash_white.svg') }}" style="height:18px">
            </button>
        </div>
    </div>

    <div class="contact-body" id="inq_display{{ $record->id }}" style="display:none">
        <div class="contact-body-inset" style="background-color:rgb(203, 204, 208);">
            联系方式&nbsp;: {{ $record->type }}&nbsp;-&nbsp;{{ $record->contact }}
        </div>
        <div class="contact-body-inset">
            {{ $record->body }}
        </div>
    </div>

    @php
        $index++;
        $recordsIndex++;
    @endphp
@endforeach

<br>
<div class="inqPages">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <span>查询总数: {{ count($allRecords)}}</span>
            <span>目前显示: {{ $displayStart}} 
            @if($onDisplay>$displayStart)
             - {{ $onDisplay}} 
             @endif
             </span>
        </div>
        <div class="col-md-2">
            <div class="btn-group" role="group" aria-label="Pagination">
                @if ($recordsIndex -10 > 0)
                    <a onCLick="paginateInquiries({{$ogIndex-10}})" class="btn btn-primary"><img src="{{ asset('icons/arrow_left.svg') }}" style="height:18px"></a>
                @endif
                @if (count($allRecords)>$recordsIndex)
                    <a onCLick="paginateInquiries({{$recordsIndex}})" class="btn btn-primary"><img src="{{ asset('icons/arrow_right.svg') }}" style="height:18px"></a>
               @endif
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>






{{-- @php

    $index = 0;

@endphp

@foreach ($records as $record)
    @php
        $date = $record->created_at->format('Y-m-d');

    @endphp

    <div class = "row center-paginate" style= "background-color:#ced8e3;" id ="contact_paginate{{ $record->id }}">

        <div class= 'col-md-4 '>
            <p>{{ $date }}</p>
        </div>
        <div class= 'col-md-4'>
            <p>{{ $record->name }}</p>
        </div>
        <div class= 'col-md-2' style="text-align:center">

            @if ($record->read)
                <button onClick="showInquiry('{{ $record->id }}')" class='btn btn-secondary' style='margin-top:4px'
                    id="showInquiry_btn{{ $record->id }}">
                    <img src="{{ asset('icons/glasses_white.svg') }}" id="read_contact{{ $record->id }}">
                </button>
            @else
                <form id= "mark_contact_read_{{ $record->id }}" style="display:none"> @csrf
                    <input type="hidden" name="form_name" value="mark_contact_read_{{ $record->id }}">
                    <input type = "hidden" name="inq_id" value={{ $record->id }}>
                </form>
                <button onCLick = "markContactRead('{{ $record->id }}')" id="showInquiry_btn{{ $record->id }}"
                    class='btn btn-warning' style='margin-top:4px'>
                    <img src="{{ asset('icons/glasses.svg') }}" style="height:18px"
                        id="read_contact{{ $record->id }}">
                </button>
            @endif

        </div>
        <div class= 'col-md-2' style="text-align:center">
            <button class='btn btn-danger' style='margin-top:4px'
                onClick="openMainModal('deleteInquiry','{{ json_encode($record) }}','.modal-sm')">
                <img src="{{ asset('icons/trash_white.svg') }}">
            </button>
        </div>
    </div>

    <div class="contact-body" id ="inq_display{{ $record->id }}" style="display:none">
        <div class = 'contact-body-inset' style="background-color:rgb(203, 204, 208);">
          联系方式 &nbsp;: {{ $record->type }}&nbsp;-&nbsp;{{ $record->contact }}
        </div>
        <div class = 'contact-body-inset'>
            {{ $record->body }}
        </div>
    </div>
    @php
        $index++;
    @endphp
@endforeach

<br>
<div class="pagination">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <span>Total Records: {{ $records->total() }}</span>
            <span>Current Page: {{ $records->currentPage() }}</span>
        </div>
        <div class="col-md-2">
            <div class="btn-group" role="group" aria-label="Pagination">
                @if ($records->onFirstPage())
                    <button class="btn btn-primary" disabled><img src="{{ asset('icons/arrow_left.svg') }}"></button>
                @else
                    <a href="{{ $records->previousPageUrl() }}" class="btn btn-primary"><img src="{{ asset('icons/arrow_left.svg') }}"></a>
                @endif

                @if ($records->hasMorePages())
                    <a href="{{ $records->nextPageUrl() }}" class="btn btn-primary"><img src="{{ asset('icons/arrow_right.svg') }}"></a>
                @else
                    <button class="btn btn-primary" disabled><img src="{{ asset('icons/arrow_right.svg') }}"></button>
                @endif
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<div class="pagination-links">
    {{ $records->links() }}
</div>
 --}}

{{-- <div class="pagination">
    <div class = "row">
        <div class="col-md-1">
        </div>
        <div class="col-md-8">
            <span>Total Records: {{ $records->total() }}</span>
            <span>Current Page: {{ $records->currentPage() }}</span>
        </div>
        <div class= "col-md-1">
            <a href="{{ $records->previousPageUrl() }}" class="btn btn-primary"
                @if (!$records->previousPageUrl()) disabled @endif><img src="{{ asset('icons/arrow_left.svg') }}"></a>
        </div>
        <div class= "col-md-1">
            <a href="{{ $records->nextPageUrl() }}" class="btn btn-primary"
                @if (!$records->nextPageUrl()) disabled @endif><img src="{{ asset('icons/arrow_right.svg') }}"></a>

        </div>
        <div class="col-md-1">
        </div>
    </div>
</div> --}}



{{-- Blade Pagination --}}




<style>
    .center-paginate {
        padding-top: 6px !important;
        margin-bottom: 6px;
    }

    .contact-body {
       
    }
      .contact-body-inset {
        padding: 8 12;
    }
</style>
