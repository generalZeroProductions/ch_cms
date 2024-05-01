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
                     @if (Auth::check())
                         @if ($editMode)
                             @include('nav.partials.nav_item_edit', ['nav' => $nav, 'canDelete'=>$canDelete])
                         @else
                             @include('nav.partials.nav_item', ['nav' => $nav])
                         @endif
                     @else
                         <li class="nav-item {{ $loop->first ? 'active' : '' }}">
                             @include('nav.partials.nav_item', ['nav' => $nav])
                         </li>
                     @endif
                 @endif
                 @if ($nav->type === 'drop')
                     @if (Auth::check())
                         @if ($editMode)
                             @include('nav.partials.nav_drop_edit_mode', ['nav' => $nav, 'canDelete'=>$canDelete])
                         @else
                             @include('nav.partials.dropdown_nav', ['nav' => $nav])
                         @endif
                     @else
                         @include('nav.partials.dropdown_nav', ['nav' => $nav])
                     @endif
                 @endif
             @endforeach
         </ul>
        @if (Auth::check())
             @if ($editMode) 
                 <div class = "col-auto ">
                     <a href = "#" id="add_nav_anchor"
                         onClick="openMainModal('nav?selectNavType', null,'{{ json_encode($location) }}','modal-md')">
                         <img src = "{{ asset('icons\add.svg') }}" class="add-nav-icon">
                         <div class="tooltip-text" id="tooltip-1">将新项目添加到导航栏</div>
                     </a>
                 </div>
             @endif
         @endif 

     </div>
 </nav>
