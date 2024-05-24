@php
    use App\Models\ContentItem;
    $index = 0;
    $ogIndex = $recordsIndex;
    $records = $allRecords->slice($recordsIndex, 10);
    $displayStart = $ogIndex + 1;
    $displayEnd = 0;
    $onDisplay = $ogIndex + count($records);
@endphp

@foreach ($records as $record)
    @php
        $heading = '无内容';
        $topRow = ContentItem::where('parent', $record->id)
            ->orderBy('index')
            ->first();
        if (isset($topRow)) {
            Log::info($topRow);
            $heading = $topRow->body;
        }

    @endphp
    @if ($index % 2 !== 0)
        <div class = "row center-paginate">
        @else
            <div class = "row center-paginate" style= "background-color:#ced8e3;">
    @endif
    <div class= 'col-md-4 '>
        <p>{{ $record->title }}</p>
    </div>
    <div class= 'col-md-4'>
        <p>{{ $heading }}</p>
    </div>
    <div class= 'col-md-2' style="text-align:center">
        <button onClick="enterPageBuild('{{ $record->title }}','dashboard', null)" class='btn btn-primary'
            style='margin-top:4px'>
            <img src="{{ asset('icons/build.svg') }}">
        </button>
    </div>
    <div class= 'col-md-2' style="text-align:center">
        @if (count($allRecords) > 1)
            <button class='btn btn-danger' style='margin-top:4px'
                onClick="openMainModal('deletePage','{{ json_encode($record) }}','model-sm')">
                <img src="{{ asset('icons/trash_white.svg') }}">
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
