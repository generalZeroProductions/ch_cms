@php
    $tabCol = 'tab_col_' . $rowId;
    $contentCol = 'content_col_' . $rowId;
    $contentBoxId = 'content_' . $rowId;
    $tab0Route = $tab0->route;
    $tab0Index = $tab0->index;
    $tab0Id = $tab0->id;
    $tagAnchor = 'tab_' . $rowId . $tab0->index;
@endphp

    <div class="row" id="{{ $rowId }}">
        <div class="col-3 tab-menu" id = "{{ $tabCol }}">
            @include('/tabs/tab_menu', [
                'tabs' => $tabs,
                'tab0' => $tab0,
                'rowId' => $rowId,
                'pageId' => $pageId,
                'divId' => $tabCol,
            ])
        </div>
        <div class="col-9 " id="{{ $contentCol }}">
            @php
                $i = 0;
            @endphp
            @foreach ($contents as $content)
                <div id="contents{{ $i }}" class="tabContent_{{ $rowId }}">
                    {!! $content !!}
                </div>
                @php
                    $i++;
                @endphp
            @endforeach
        </div>
    </div>


<div class = 'run-scripts'>
    <script>
        changeTab('{{ $rowId }}', '{{ $tagAnchor }}', '{{ $tab0Index }}', false);
    </script>
</div>
