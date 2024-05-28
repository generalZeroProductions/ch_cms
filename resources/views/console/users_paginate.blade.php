@php
    use App\Models\User;
    $index = 0;
    $ogIndex = $recordsIndex;
    $records = $allRecords->slice($recordsIndex, 10);
    $displayStart = $ogIndex + 1;
    $displayEnd = 0;
    $onDisplay = $ogIndex + count($records);
@endphp

@foreach ($records as $record)
    @if ($index % 2 !== 0)
        <div class = "row center-paginate">
        @else
            <div class = "row center-paginate" style= "background-color:#ced8e3;">
    @endif
    <div class= 'col-md-4 '>
        <p>{{ $record->name }}</p>
    </div>
    <div class= 'col-md-4'>

    </div>
    <div class= 'col-md-2' style="text-align:center">
        @php
            $jItem = ['user' => $record, 'users' => $allRecords];
        @endphp
        <button onClick="openMainModal('editUser','{{ json_encode($jItem) }}', 'modal-sm')" class='btn btn-warning'
            style='margin-top:4px'>
            <img src="{{ asset('icons/edit_user.svg') }}">
        </button>
    </div>
    <div class= 'col-md-2' style="text-align:center">
        @if ($record->id > 1)
            <button class='btn btn-danger' style='margin-top:4px'
                onClick="openMainModal('deleteUser','{{$record->id }}','model-sm')">
                <img src="{{ asset('icons/delete_user.svg') }}">
            </button>
        @endif
    </div>
    </div>
    @php
        $index++;
        $recordsIndex;
    @endphp
@endforeach

<br>
<div class="inqPages">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <span>总页数: {{ count($allRecords) }}</span>
            <span>目前显示: {{ $displayStart }}
                @if ($onDisplay > $displayStart)
                    - {{ $onDisplay }}
                @endif
            </span>
        </div>
        <div class="col-md-2">
            <div class="btn-group" role="group" aria-label="Pagination">
                @if ($recordsIndex - 10 > 0)
                    <a onCLick="paginatePages({{ $ogIndex - 10 }})" class="btn btn-primary"><img
                            src="{{ asset('icons/arrow_left.svg') }}" style="height:18px"></a>
                @endif
                @if (count($allRecords) > $recordsIndex)
                    <a onCLick="paginatePages({{ $recordsIndex }})" class="btn btn-primary"><img
                            src="{{ asset('icons/arrow_right.svg') }}" style="height:18px"></a>
                @endif
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>


<style>
    .center-paginate {
        padding-top: 6px !important;
    }
</style>
