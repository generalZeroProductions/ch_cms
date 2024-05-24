@php
    $scrollTabs = 'scroll_' . $rowId;
    $jTabs = json_encode(['pageId' => $pageId, 'tabs' => $tabs, 'rowId' => $rowId]);
@endphp

<div style= "height:0" id="{{ $scrollTabs }}">
@if ($editMode)
    <div style= "height:44"></div>
    <div class="tabs-editor-spacing">
        <a style= "cursor: pointer;" onClick = "insertForm('edit_tabs','{{ $jTabs }}',  '{{ $divId }}')">
            <img src="{{ asset('icons/pen.svg') }}"class="tab-edit-pen">
        </a>
    </div>
@endif

<div>
    <ul id="tabs">
        @foreach ($tabs as $tab)
            @php
                $anchorId = 'tab_' . $rowId . $tab->index;
            @endphp
            <li class =  "{{ $loop->first ? 'active' : '' }} tab-no-dots">
                <a style="cursor:pointer" id = "{{ $anchorId }}" class = "tab-body-on"
                    onClick= "changeTab('{{ $rowId }}','{{ $anchorId }}', '{{ $loop->index }}', true)">
                    {{ $tab->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
</div>

<div class = 'run-scripts'>
    <script>
        setTabMenuScroll('{{ $scrollTabs }}');
    </script>
</div>
