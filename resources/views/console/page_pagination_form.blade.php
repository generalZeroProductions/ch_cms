
 @php
    use App\Models\ContentItem;
    $index = 0;
@endphp

@foreach ($records as $record)
    @php
          $heading = 'movie';
          $topRow = ContentItem::where('parent',$record->id)->orderBy('index')->first();
         $heading = $topRow->heading;
    @endphp
    @if ($index % 2 === 0)
        <div class = "row">
        @else
            <div class = "row" style= "background-color:#ced8e3;">
    @endif
    <div class= 'col-md-4'>
        <p>{{ $record->title }}</p>
    </div>
    <div class= 'col-md-4'>
        <p>{{ $heading }}</p>
    </div>
    <div class= 'col-md-2' style="text-align:center">
        <button onClick="enterPageBuild('{{ $record->title }}',null,null)" class='btn btn-primary' style='margin-top:4px'>
            <img src="{{ asset('icons/build.svg') }}">
        </button>
    </div>
    <div class= 'col-md-2' style="text-align:center">
        <button class='btn btn-danger' style='margin-top:4px'
            onClick="openMainModal('deletePage','{{ json_encode($record) }}','null','model-sm')">
            <img src="{{ asset('icons/trash_white.svg') }}">
        </button>
    </div>
    </div>
    @php
        $index++;
    @endphp
@endforeach

<br>
<div class="pagination">
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
</div>