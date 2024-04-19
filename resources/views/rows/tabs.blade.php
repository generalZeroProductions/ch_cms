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
    $defaultRoute = $tabs[0]->route;
    $defaultLink = $linkId = 'tab_'.$tabs[0]->title;
    $menuId = 'menu_' . $row->id;
    $contentId = 'content_'.$row->id;
    $ulId = 'ul_'.$row->id;
    $editMode = true;
@endphp
<div class="row space-row">
    <div class="col-md-4" id = "{{ $menuId }}">
    <div style = "margin-left:24px">
        <ul class="tab_ul" id = "{{$ulId}}">
            @foreach ($tabs as $tab)
                <li>
                @php
                $linkId = 'tab_'.$tab->title;
                @endphp
                    <a href="#" id = "{{$linkId}}" onClick = "loadTab('{{$contentId}}','{{$tab->route}}',  '{{$ulId}}', '{{$linkId}}')">
                        {{ $tab->title }}
                    </a>
                </li>
            @endforeach
        </ul>
        </div>
    </div>
    <div class="col-md-8" id = "{{$contentId}}">
        content
    </div>
</div>
<div id= "runScripts">
<script>
loadTab('{{$contentId}}','{{$defaultRoute}}','{{$ulId}}','{{$defaultLink}}');
</script>

</div>