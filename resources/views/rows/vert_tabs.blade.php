@php
    use App\Models\ContentItem;
    use App\Models\Navigation;
    $tabData = $location['row']['data']['tabs'];
    $tabContents = [];
    $tabs = [];
    $contentRoutes = [];
    foreach ($tabData as $tabId) {
        $nextTab = Navigation::findOrFail($tabId);
        $tabs[] = $nextTab;
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
    $aIndex = 0;

@endphp




<div class="accordion" id="accordionExample">
    @foreach ($tabs as $tab)
        <div class="card">
            <div class="card-header tab_colors" id="heading{{ $aIndex }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left tab_header_def" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $aIndex }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="collapse{{ $aIndex }}" onClick="setAccordian('{{$contentRoutes[$aIndex]}}','content_{{ $aIndex }}')">
                        {{ $tab->title }}
                    </button>
                </h2>
            </div>
            <div id="collapse{{ $aIndex }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                aria-labelledby="heading{{ $aIndex }}" data-parent="#accordionExample">
                <div class="card-body" id="content_{{ $aIndex }}">
                </div>
            </div>
        </div>
        @php
            $aIndex++;
        @endphp
    @endforeach
</div>




<div id="runScripts">
    <script>
        menuFolder('{{ $contentRoutes[0] }}');
    </script>
</div>
<style>
.tab_header_def {
     color: #333 !important;
}

.tab_header_def:hover {
    text-decoration: none !important; /* Remove text decoration on hover */
    color: #333 !important; /* Reset text color on hover */
}
.tab_colors{
    background-color: #bdc3ca;
}
.tab_colors:hover{
    background-color: #5499e3;
}
</style>