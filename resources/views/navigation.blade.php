@php
    use App\Models\Navigation;
    use App\Models\ContentItem;
    $navs = Navigation::where('type', 'nav')->get();
    $drops = Navigation::where('type', 'drop')->get();
    $navItems = $navs->merge($drops);
    if ($editMode) {
        $allPages = ContentItem::where('type', 'page')->get();
        $allPageTitles = $allPages->pluck('title')->toArray();
    }

@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav ml-auto">
            @foreach ($navItems as $nav)
                @if ($nav->type === 'nav')
                    @if ($editMode)
                        <div class = "row" id = "{{ $nav->id }}_{{ $nav->title }}">
                    @endif
                    <li class="nav-item {{ $loop->first ? 'active' : '' }}">
                        <a href="#" class="nav-link" onClick="loadPageFromNav('{{$nav->route}}')">
                            <span class="menu-name">{{ $nav->title }}</span>
                        </a>
                    </li>
                    @if ($editMode)
                        <a href="#" class="edit-nav-pen"
                            onClick="loadEditNav('{{ json_encode($nav) }}','{{ $nav->id }}_{{ $nav->title }}','{{json_encode($location)}}')">
                            <img src = "{{ asset('icons\pen.svg') }}">
                        </a>
                        <a href = "#" class = "edit-nav-trash"
                            onClick="openBaseModal('removeItem','{{ json_encode($nav) }}', '{{json_encode($location)}}')">
                            <img src = "{{ asset('icons\trash.svg') }}">
                        </a>
    </div>
    @endif
    @endif
    @if ($nav->type === 'drop')
        @if ($editMode)
            <div class = "row">
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {{ $nav->title }}
            </a>
            @php
                $subNavItems = [];
                $navData = $nav->data['items'];
                foreach ($navData as $itemId) {
                    $nextItem = Navigation::findOrFail($itemId);
                    if ($nextItem) {
                        $subNavItems[] = $nextItem;
                    }
                }

            @endphp

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach ($subNavItems as $subNav)
                    <a class="dropdown-item" href="#">{{ $subNav->title }}</a>
                @endforeach
            </div>
        </li>
        @if ($editMode)
            <a href = "#" class = "edit-nav-pen"
                onClick="editDropdown('{{ json_encode($nav) }}','{{ json_encode($subNavItems) }}','{{ json_encode($location) }}')">
                <img src = "{{ asset('icons\pen.svg') }}">
            </a>
            <a href = "#" class = "edit-nav-trash"
                onClick="openBaseModal('removeItem','{{ json_encode($nav) }}', '{{json_encode($location)}}')">
                <img src = "{{ asset('icons\trash.svg') }}">
            </a>
            </div>
        @endif
    @endif
    @endforeach



    </ul>
    @if ($editMode)
        <div class = "col-auto ">
            <a href = "#" class = "edit-nav-add"
                onClick="openBaseModal('selectNavType', null,'{{json_encode($location)}}')">
                <img src = "{{ asset('icons\add.svg') }}" id = "hoverIcon">
            </a>
            <div class="tooltip-text" id="tooltip-1">将新项目添加到导航栏</div>
        </div>
        <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">仪表板
             <img src = "{{ asset('icons\dashboard.svg') }}" style = "margin-bottom: 2 px; margin-left:4px">
            </button>
        </form>
    @endif
    </div>
</nav>

<script>
    var element = document.getElementById('hoverIcon');

    element.addEventListener('mouseover', function() {
        showTooltip('tooltip-1');
    });

    element.addEventListener('mouseout', function() {
        hideTooltip('tooltip-1');
    });


  

    document.addEventListener('DOMContentLoaded', function() {
        var navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(function(navLink) {
            navLink.addEventListener('click', function(event) {
                var parentNavItem = this.closest('.nav-item');
                document.querySelectorAll('.nav-item').forEach(function(item) {
                    item.classList.remove('active');
                });

                parentNavItem.classList.add('active');
            });
        });
    });
        function loadPageFromNav(route) {
        // Run your loadPage function
        loadPage(route);

        // Collapse the navbar after a short delay
        setTimeout(function () {
            $('.navbar-collapse').collapse('hide');
        }, 100);
    }
</script>
