@php
    use Illuminate\Support\Facades\Log;
    $nextDrop = 0;
@endphp

<div id = "site_nav_bar">
<nav class="navbar navbar-expand-lg navbar-light bg-light" >
    @if (!$editMode)
        <a class="navbar-brand" href="/" style="display: flex; align-items: center;">
         <img src="{{ asset("images/$logo->route") }}" class="main-logo-crop">
         <h3>{{$logo->title}}</h3>
         </a>
    @endif
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav ml-auto">
            @foreach ($navItems as $nav)
                @if ($nav->type === 'nav')
                    @if ($editMode)
                        @include('nav.partials.nav_item_edit_mode', [
                            'nav' => $nav,
                            'canDelete' => $canDelete
                        ])
                        @include('nav.partials.new_nav_item')
                    @else
                        @include('nav.partials.nav_item', ['nav' => $nav])
                    @endif
                @endif
                @if ($nav->type === 'drop')
                    @if ($editMode)
                        @include('nav.partials.dropdown_edit_mode', [
                            'nav' => $nav,
                            'canDelete' => $canDelete,
                            'subs' => $dropData[$nextDrop]
                        ])
                        @include('nav.partials.new_nav_item',['nav'=>$nav])
                    @else
                        @include('nav.partials.dropdown', [
                            'nav' => $nav,
                            'subs' => $dropData[$nextDrop]
                        ])
                    @endif
                    @php
                        $nextDrop += 1;
                    @endphp
                @endif
            @endforeach
        </ul>
    </div>
</nav>
</div>


<style>
    .main-logo-crop {
        width: auto;
        height: 54px;
        object-fit: cover;
        margin-right:12px;
         margin-left:18px;
    }

</style>