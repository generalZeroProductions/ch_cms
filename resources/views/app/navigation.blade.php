@php
    use App\Models\Navigation;
    use App\Models\ContentItem;
    use Illuminate\Support\Facades\Session;
    $navs = Navigation::where('type', 'nav')->get();
    $drops = Navigation::where('type', 'drop')->get();
    $navItems = Navigation::whereIn('type', ['nav', 'drop'])
        ->orderBy('index')
        ->get();
    $editMode = getEditMode();
    $buildMode = getBuildMode();
    $canDelete = true;
    if (count($navItems) === 1) {
        $canDelete = false;
    }
    if (Auth::check()) {
        if ($editMode) {
            $allPages = ContentItem::where('type', 'page')->get();
            $allPageTitles = $allPages->pluck('title')->toArray();
        }
    }

@endphp
<div class="nav-fixed-top" id="main_navigtion">
    @if (Auth::check())
        @include('app/layouts/partials/edit_mode_banner', ['route' => $route])
        @if (!$buildMode)
            @include('app.nav', ['canDelete' => $canDelete])
        @endif
    @else
        @include('app.nav', ['canDelete' => $canDelete])


    @endif
</div>
<script id="runScripts"></script>
<script>
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
        {{-- setTimeout(function() {
            $('.navbar-collapse').collapse('hide');
        }, 100); --}}
        fetch("/changelocation/" + route).then((response) => response.text()) // Parse response as text
            .then(() => {
                window.location.href = '/' + route;
            })
            .catch((error) => console.error("Error loading page:", error))
    }
</script>

@if (Auth::check())
    @if (!$editMode)
        <style>
            .navbar {
                padding-right: 80px !important;
            }
        </style>
    @endif
@endif
<style>
    .nav-fixed-top {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: #ffffff;
        z-index: 1000;
    }
</style>
