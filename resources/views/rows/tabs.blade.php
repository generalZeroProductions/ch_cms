@php
    use App\Models\ContentItem;
    use App\Models\Navigation;
    $editMode = false;
    if (isset($_SESSION['edit'])) {
        $editMode = $_SESSION['edit'];
    }

    $data = $row->data;
    $tabData = $data['tabs'];

    $tabs = [];
    foreach ($tabData as $tabId) {
        $nextTab = Navigation::findOrFail($tabId);
        $tabs[] = $nextTab;
    }
    $defaultRoute = $tabs[0]->route;
    $defaultLink = $linkId = 'tab_' . $tabs[0]->id;
    $menuId = 'menu_' . $row->id;
    $contentId = 'content_' . $row->id;
    $ulId = 'ul_' . $row->id;

    if ($editMode) {
        $allRoutes = ContentItem::where('type', 'page')->get();
        $routes = $allRoutes->pluck('title')->toArray();
    }
@endphp

<div class="row space-row" style= "padding-left:15px; margin-left:18px">
    <div class="col-md-2" id = "{{ $menuId }}">
        @if ($editMode)
            <div class = "row">
                <a href = "#" class = "edit-nav-pen"
                    onClick="editTabsList({{ json_encode($tabs) }}, {{ json_encode($routes) }}, '{{ $menuId }}','{{ $row->id }}','{{ $pageName }}')">
                    <img src = "{{ asset('icons\pen.svg') }}">
                </a>
            </div>
        @endif

        <div style = "margin-left:18px">
            <ul class="tab_ul" id = "{{ $ulId }}">
                @foreach ($tabs as $tab)
                    <li>
                        <a href="#" id = "tab_{{ $tab->id }}"
                            onClick = "loadTab('{{ $contentId }}','{{ $tab->route }}',  '{{ $ulId }}', 'tab_{{ $tab->id }}')">
                            {{ $tab->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
    <div class="col-md-10" id = "{{ $contentId }}">
    </div>
</div>

<div id= "runScripts">
    <script>
        loadTab('{{ $contentId }}', '{{ $defaultRoute }}', '{{ $ulId }}', '{{ $defaultLink }}');
    </script>

</div>
