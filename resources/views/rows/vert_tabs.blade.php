@php
    use App\Models\ContentItem;
    use App\Models\Navigation;
    $data = $row->data;
    $tabData = $data['tabs'];

    $tabs = [];
    foreach ($tabData as $tabId) {
        $nextTab = Navigation::findOrFail($tabId);
        $tabs[] = $nextTab;
    }
    $contentRoutes = [];
    foreach ($tabs as $nextTab) {
        $contentRoutes[] = $nextTab->route;
    }
    $sendRoutes = json_encode($contentRoutes);
    $defaultRoute = $tabs[0]->route;
    $defaultLink = $linkId = 'tab_' . $tabs[0]->title;
    $menuId = 'menu_' . $row->id;
    $contentId = 'content_' . $row->id;
    $ulId = 'ul_' . $row->id;
    $editMode = true;
    $contentIndex = 0;
@endphp

<ul id="menu">
    @foreach ($tabs as $tab)
        <li>
            <a href="#">{{ $tab->title }}</a>
            <div class="hidden-content" id = "content_{{ $tab->id }}">content</div>
        </li>
        @php
            $contentIndex += 1;
        @endphp
    @endforeach
    <!-- Add more menu items as needed -->
</ul>

<div id="runScripts">
    <script>
        menuFolder('{{$sendRoutes}}');
    </script>
</div>

