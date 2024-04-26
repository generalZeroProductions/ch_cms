@if (count($slideList) > 0)
  <div id="{{ $slideBox }}">
 @if ($editMode)
                <div class="row title_change_div">
                    <div class="col-md-10" id = "{{ $location['row']['id'] }}">
                        <p class = "title_indicator"> Edit Slideshow</p>
                        <a href="#"
                            onClick = "editSlidesForm('{{ $slideBox }}','{{ json_encode($location) }}', '{{ json_encode($slideJson) }}')">
                            <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                        </a>
                    </div>
                    <div class = "col-md-2 delete_row_button">
                        @include('rows/delete_row_button')
                    </div>
                </div>
       
    @endif
@if (count($slideList) > 1)

 <div class="carousel slide" data-ride="carousel" id = "{{ $slideshowId }}">
        <!-- Indicators -->
        <ul class="carousel-indicators">
            @foreach ($slideList as $slide)
                @if ($index === 0)
                    <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}" class="active">
                    </li>
                @else
                    <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}1"></li>
                @endif
                @php
                    $index += 1;
                @endphp
            @endforeach

        </ul>
        @php
            $index = 0;
        @endphp
        <!-- The slideshow -->
        <div class="carousel-inner">
            @foreach ($slideList as $slide)
                @if ($index === 0)
                    <div class="carousel-item banner_container active">
                    @else
                        <div class="carousel-item banner_container">
                @endif
                <img src ="{{ asset('images/' . $slide->image) }} " class = "image-fluid">
        </div>
        @php
            $index += 1;
        @endphp
@endforeach
</div>
<a class="carousel-control-prev" href="#{{ $slideshowId }}" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#{{ $slideshowId }}" data-slide="next">
    <span class="carousel-control-next-icon"></span>
</a>
</div>
</div>
@else
 <img src ="{{ asset('images/' . $slideList[0]['image']) }} " class = "image-fluid">
</div>
<label for="color">Choose a color:</label>
<input type="color" id="color" name="color">
@endif
@endif
<div class="row row_add_button">
    @include('rows/add_row_button', ['location' => $location])
</div>


  </div>
    
      
           

   

<!-- Left and right controls -->

<div class="banner_container" id="{{ $slideBox }}">
    @if ($editMode)
        <div class="row title_change_div">
            <div class="col-md-3" id = "{{ $row->id }}">
                <p class = "title_indicator"> Edit Slideshow</p>
                <a href="#" onClick = "editSlidesForm('{{ $slideshowId }}','{{ json_encode($location) }}')">
                    <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                </a>
            </div>
        </div>
    @endif
    <img src ="{{ asset('images/' . $slideList[0]['image']) }} " class = "image-fluid">
</div>
<label for="color">Choose a color:</label>
<input type="color" id="color" name="color">
@endif
@endif
<div class="row row_add_button">
    @include('rows/add_row_button', ['location' => $location])
</div>






@if (count($slideList) > 0)
    @if (count($slideList) > 1)
        <div id="{{ $slideBox }}">
            @if ($editMode)
                <div class="row title_change_div">
                    <div class="col-md-10" id = "{{ $location['row']['id'] }}">
                        <p class = "title_indicator"> Edit Slideshow</p>
                        <a href="#"
                            onClick = "editSlidesForm('{{ $slideBox }}','{{ json_encode($location) }}', '{{ json_encode($slideJson) }}')">
                            <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                        </a>
                    </div>
                    <div class = "col-md-2 delete_row_button">
                        @include('rows/delete_row_button')
                    </div>
                </div>
       
    @endif

    <div class="carousel slide" data-ride="carousel" id = "{{ $slideshowId }}">
        <!-- Indicators -->
        <ul class="carousel-indicators">
            @foreach ($slideList as $slide)
                @if ($index === 0)
                    <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}" class="active">
                    </li>
                @else
                    <li data-target="#{{ $slideshowId }}" data-slide-to="{{ $index }}1"></li>
                @endif
                @php
                    $index += 1;
                @endphp
            @endforeach

        </ul>
        @php
            $index = 0;
        @endphp
        <!-- The slideshow -->
        <div class="carousel-inner">
            @foreach ($slideList as $slide)
                @if ($index === 0)
                    <div class="carousel-item banner_container active">
                    @else
                        <div class="carousel-item banner_container">
                @endif
                <img src ="{{ asset('images/' . $slide->image) }} " class = "image-fluid">
        </div>
        @php
            $index += 1;
        @endphp
@endforeach
</div>

<!-- Left and right controls -->
<a class="carousel-control-prev" href="#{{ $slideshowId }}" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#{{ $slideshowId }}" data-slide="next">
    <span class="carousel-control-next-icon"></span>
</a>
</div>
</div>
@else
<div class="banner_container" id="{{ $slideBox }}">
    @if ($editMode)
        <div class="row title_change_div">
            <div class="col-md-3" id = "{{ $row->id }}">
                <p class = "title_indicator"> Edit Slideshow</p>
                <a href="#" onClick = "editSlidesForm('{{ $slideshowId }}','{{ json_encode($location) }}')">
                    <img src="{{ asset('icons/pen.svg') }}" style = "margin-bottom: 4px; margin-left:8px">
                </a>
            </div>
        </div>
    @endif
    <img src ="{{ asset('images/' . $slideList[0]['image']) }} " class = "image-fluid">
</div>
<label for="color">Choose a color:</label>
<input type="color" id="color" name="color">
@endif
@endif
<div class="row row_add_button">
    @include('rows/add_row_button', ['location' => $location])
</div>




//   TAB STRUCT ACCORDIAN




@php
    use App\Models\ContentItem;
    use App\Models\Navigation;
    $tabData = $location['row']['data']['tabs'];
    $tabContents = [];
    $tabs = [];
    foreach ($tabData as $tabId) {
        $nextTab = Navigation::findOrFail($tabId);
        $tabs[] = $nextTab;
        $content = ContentItem::where('title', $nextTab->route)->first();
    }

    $contentRoutes = [];

    $sendRoutes = json_encode($contentRoutes);
    $defaultRoute = $tabs[0]->route;
    $defaultLink = $linkId = 'tab_' . $tabs[0]->title;
    $menuId = 'menu_' . $location['row']['id'];
    $contentId = 'content_' . $location['row']['id'];
    $ulId = 'ul_' . $location['row']['id'];
    $editMode = true;
    $contentIndex = 0;
    $accordianIndex = 0;
@endphp
{{-- 
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
</div> --}}



<div class="accordion" id="accordionExample">
    @foreach ($tabs as $tab)
        <div class="card">
            <div class="card-header" id="heading{{ $accordianIndex }}">
                <h2 class="mb-0">
                    @if ($accordianIndex === 0)
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $accordianIndex }}" aria-expanded="true"
                            aria-controls="collapse{{ $accordianIndex }}">
                        @else
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapse{{ $accordianIndex }}" aria-expanded="false"
                                aria-controls="collapse{{ $accordianIndex }}">
                    @endif
                    {{ $tabs[$accordianIndex]->title }}
                    </button>
                </h2>
            </div>
            @if ($accordianIndex === 0)
                <div id="collapse{{ $accordianIndex }}" class="collapse show"
                    aria-labelledby="heading{{ $accordianIndex }}" data-parent="#accordionExample">
                @else
                    <div id="collapse{{ $accordianIndex }}" class="collapse"
                        aria-labelledby="heading{{ $accordianIndex }}" data-parent="#accordionExample">
            @endif
            <div class="card-body">
                Some placeholder content for the first accordion panel. This panel is shown by default, thanks to the
                <code>.show</code> class.
            </div>
        </div>
</div>
@php
    $accordianIndex += 1;
@endphp
@endforeach
</div>


<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Collapsible Group Item #1
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                Some placeholder content for the first accordion panel. This panel is shown by default, thanks to the
                <code>.show</code> class.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Collapsible Group Item #2
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                Some placeholder content for the second accordion panel. This panel is hidden by default.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Collapsible Group Item #3
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by
                default.
            </div>
        </div>
    </div>
</div>





{{-- ORIGINAL STRUCT  --}}


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

