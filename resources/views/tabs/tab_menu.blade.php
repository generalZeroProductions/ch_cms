@php
    $scrollTabs = 'scroll_' . $rowId;
    $jTabs = json_encode(['pageId'=>$pageId, 'tabs' => $tabs, 'rowId' => $rowId]);
@endphp

<div style= "height:0" id="{{ $scrollTabs }}"></div>
@if ($editMode)
    <div style= "height:44"></div>
    <div class="pen-icon">
        <a style= "cursor: pointer;" onClick = "insertForm('edit_tabs','{{ $jTabs }}',  '{{ $divId }}')">
            <img src="{{ asset('icons/pen.svg') }}"class="tab-edit-pen">
        </a>
    </div>
@endif

<div>
    <ul id="tabs">
        @foreach ($tabs as $tab)
            @php
                $anchorId = 'tab_' .$rowId. $tab->index;
            @endphp
            <li class =  "{{ $loop->first ? 'active' : '' }} no_dots">
                <a style="cursor:pointer" id = "{{ $anchorId }}" class = "tab-body-on"
                    onClick= "changeTab('{{ $rowId }}','{{ $anchorId }}', '{{ $loop->index }}', true)">
                    {{ $tab->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<style>
    .tab-edit-pen {
        height: 20px;
    }

    .pen-icon {
        margin-top: 8px;
        margin-bottom: 8px;
        padding-left: 28px;
    }
</style>

<div class = 'run-scripts'>
    <script>
        setTabMenuScroll('{{ $scrollTabs }}');
    </script>
</div>
