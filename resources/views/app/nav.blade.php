
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
     <a class="navbar-brand" href="#">Navbar</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
         aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="navbarSupportedContent">

         <ul class="navbar-nav ml-auto">
             @foreach ($navItems as $key=> $nav)
                 @if ($nav->type === 'nav')
                     @if (1===1)
                         @if ($editMode)
                             @include('nav.partials.nav_item_edit', [
                                 'nav' => $nav,
                                 'canDelete' => $canDelete,
                             ])
                             @include('nav.partials.new_nav_item')
                         @else
                             @include('nav.partials.nav_item', ['nav' => $nav])
                         @endif
                     @else
                         @include('nav.partials.nav_item', ['nav' => $nav])
                     @endif
                 @endif
                 @if ($nav->type === 'drop')
                     @if (1===1)
                         @if ($editMode)
                             @include('nav.partials.nav_drop_edit_mode', [
                                 'nav' => $nav,
                                 'canDelete' => $canDelete,
                             ])
                               @include('nav.partials.new_nav_item')
                         @else
                             @include('nav.partials.dropdown_nav', ['nav' => $nav])
                         @endif
                     @else
                         @include('nav.partials.dropdown_nav', ['nav' => $nav])
                     @endif
                 @endif
             @endforeach
         </ul>
     </div>
 </nav>
