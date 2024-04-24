@php
    use App\Models\ContentItem;
    use App\Models\Navigation;
    $tabData = $location['row']['data']['tabs'];
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
    $menuId = 'menu_' . $location['row']['id'];
    $contentId = 'content_' . $location['row']['id'];
    $ulId = 'ul_' . $location['row']['id'];
    $editMode = true;
    $contentIndex = 0;
@endphp

<ul id="menu" style="margin-left:0px; padding-left: 0px">
    @foreach ($tabs as $tab)
        <li class="menuFold">
            <div class="menu-item">
                {{ $tab->title }}
                <img src="{{ asset('icons/chevronDown.svg') }}" class="menu-icon">
            </div>
            <div class="hidden-content">
                <!-- Hidden content here -->
            </div>
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