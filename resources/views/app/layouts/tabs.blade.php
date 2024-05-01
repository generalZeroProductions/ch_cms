@php
    use App\Models\ContentItem;
    use App\Models\Navigation;

    $editMode = false;
    if (Session::has('edit')) {
        $editMode = Session::get('edit');
    }
    $tabData = $location['row']['data']['tabs'];
    $tabs = [];
    foreach ($tabData as $tabId) {
        $nextTab = Navigation::findOrFail($tabId);
        if ($nextTab) {
            $tabs[] = $nextTab;
        }
    }
    $menuId = 'menu_' . $location['row']['id'];
    $contentId = 'content_' . $location['row']['id'];
    $tab0 = $tabs[0];
    if (isset($tabAt)) {
        $tab0 = Navigation::findOrFail($tabAt);
    }

    $tab0Title = $tab0->title;
    $tab0Route = $tab0->route;
    $tab0Id = $tab0->id;
    $ulId = 'ul_' . $location['row']['id'];
    $firstLink = 'tab_' . $tabs[0]->id;

@endphp
<div class = 'container-fluid'>
    @if ($editMode)
        @include('app/layouts/partials.delete_row_button', ['index' => $location['row']['index']])
    @endif
    <div class = 'container-fluid'>
        <div class="row space-row" style= "padding-left:15px; margin-left:18px">
            <div class="col-md-2" id = "{{ $menuId }}">
                @if ($editMode)
                    <div class = "row">
                        <a href = "#" class = "edit-nav-pen"
                            onClick="editTabsList({{ json_encode($tabs) }},'{{ $menuId }}', '{{ $contentId }}', '{{ json_encode($location) }}')">
                            <img src = "{{ asset('icons\pen.svg') }}">
                        </a>
                    </div>
                @endif

                <div style = "margin-left:18px">
                    <ul id="{{ $ulId }}">
                        @foreach ($tabs as $tab)
                            <li class=" {{ $loop->first ? 'active' : '' }} tab-body-on ">
                                <a href="#" id = "tab_{{ $tab->id }}"
                                    onClick = "loadTab('{{ $tab }}', '{{ $contentId }}','{{ $ulId }}', 'tab_{{ $tab->id }}')">
                                    {{ $tab->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-10" id = "{{ $contentId }}">
                @include('tabs/no_tab_assigned')
            </div>
        </div>
    </div>
</div>
<div id="runScript">
    <script>
        startTabs('{{ $tab0Title }}', '{{ $tab0Route }}', '{{ $ulId }}', '{{ $firstLink }}',
            '{{ $contentId }}', '{{ $tab0Id }}');
    </script>
</div>

<style>
    .tab-body-on {
        list-style: none;

    }

    .tab-body-off {
        list-style: none;
    }

    .tab-item-on {
        font-size: 30px;
        font-weight: 600;
        text-decoration: none;
        color: black;
    }

    .tab-item-off {
        font-size: 24px;
        font-weight: 400;
        color: rgb(154, 154, 157);
    }

    .tab-item-off:hover {
        text-decoration: none;
        background-color: #ccc;
        color: black;
    }

    .tab-item-on:hover {
        text-decoration: none;
        background-color: #ccc;
        color: black;
    }
</style>
