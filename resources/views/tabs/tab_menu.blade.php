@php
    $scrollTabs = 'scroll_' . $rowId;
@endphp

<div id="{{ $scrollTabs }}">
    <ul id="tabs">
        @foreach ($tabs as $tab)
            @php
                $anchorId = 'tab_' . $tab->index;
            @endphp
            <li class =  "{{ $loop->first ? 'active' : '' }} no_dots">
                <a href="#" id = "{{ $anchorId }}" class = "tab-body-on"
                    onClick= "changeTab('{{ $rowId }}','{{ $anchorId }}', '{{ $loop->index }}','{{$tab->id}}')">
                    {{ $tab->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
<script>
 console.log("IN NO TAB");
</script>