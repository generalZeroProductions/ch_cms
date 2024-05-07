@php
    use App\Models\ContentItem;
    use App\Models\Navigation;
    use Illuminate\Support\Facades\View;

    $tabData = $location['row']['data']['tabs'];
    $rowId = $location['row']['id'];
    $tabs = [];
    $contents = [];
    foreach ($tabData as $tabId) {
        $nextTab = Navigation::findOrFail($tabId);
        $tabs[] = $nextTab;
    }
  
  function getHTML($page)
    {
        $tabLocation = [
            'page'=>$page,
            'row'=>null
        ];
        $mobile = true;
        $backColor = 'white';
        $tabContent = true;
        $tabTrack = '';
        $allRows = [];
        $pData = $page->data['rows'];

        foreach ($pData as $rowId) {
            $row = ContentItem::findOrFail($rowId);
            $allRows[] = $row;
        }

        usort($allRows, 'compareByIndex');
    
        $htmlString = '<div class="d-flex flex-column bd-highlight mb-3" style="background-color:' . $backColor . ';">';
   
        foreach ($allRows as $nextRow) {
           
             $tabLocation['row'] = $nextRow;
 
            if (isset($nextRow->heading) && $nextRow->heading === 'image_right') {
                $htmlString .= View::make('app.layouts.image_right', [
                    'location' =>  $tabLocation,
                    'tabContent' => $tabContent,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'two_column') {
                $htmlString .= View::make('app.layouts.two_column', [
                    'location' =>  $tabLocation,
                    'tabContent' => $tabContent,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'image_left') {
                $htmlString .= View::make('app.layouts.image_left', [
                    'location' =>  $tabLocation,
                    'tabContent' => $tabContent,
                ])->render();
    
            }
 
            if (isset($nextRow->heading) && $nextRow->heading === 'one_column') {
                $htmlString .= View::make('app.layouts.one_column', [
                    'location' =>  $tabLocation,
                    'tabContent' => $tabContent,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'banner') {
                $htmlString .= View::make('app.layouts.slideshow', [
                    'location' =>  $tabLocation,
                    'tabContent' => $tabContent,
                ])->render();
            }

            if (isset($nextRow->heading) && $nextRow->heading === 'tabs') {
                    $htmlString .= View::make('app.cant_display_tabs', [
                        'location' =>  $tabLocation,
                        'tabContent' => $tabContent,
                        'tabId' => $tabTrack,
                        'mobile' => $mobile,
                    ])->render();
            }
        }

        $htmlString .= '</div>'; // Close the wrapping div
      
        return $htmlString;
    }
     foreach ($tabs as $tab) {
        if ($tab->route === 'no_tab_assigned') {
            $html = View::make('tabs/no_tab_assigned', ['mobile' => true]);
            $contents[] = $html;
        } else {
            $page = ContentItem::where('type', 'page')
                ->where('title', $tab->route)
                ->first();

            if ($page) {
               
                $html = getHTML($page);
              
                $contents[] = $html;
            }
        }
    }
    $idx = 0;
    $tab0 = $tabs[0];
    $tab0Title = $tab0->title;
    $tab0Route = $tab0->route;
    $tab0Id = $tab0->id;
    $ulId = 'ul_' . $location['row']['id'];
    $firstLink = 'tab_' . $tabs[0]->id;

@endphp

<div class="accordion" id="accordionExample">
    @foreach ($tabs as $tab)
        <div class="card">
            <div class="card-header tab_colors" id="heading{{ $idx }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left tab_header_def" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $idx }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="collapse{{ $idx }}">
                        {{ $tab->title }} // {{$tab->route}}
                    </button>
                </h2>
            </div>
            <div id="collapse{{ $idx }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                aria-labelledby="heading{{ $idx }}" data-parent="#accordionExample">
                <div class="card-body" id="content_{{ $idx }}">
                 {!! $contents[$idx] !!}
                </div>
            </div>
        </div>
        @php
            $idx++;
        @endphp
    @endforeach
</div>





<style>
    .tab_header_def {
        color: #333 !important;
    }

    .tab_header_def:hover {
        text-decoration: none !important;
        /* Remove text decoration on hover */
        color: #333 !important;
        /* Reset text color on hover */
    }

    .tab_colors {
        background-color: #bdc3ca;
    }

    .tab_colors:hover {
        background-color: #5499e3;
    }
</style>
