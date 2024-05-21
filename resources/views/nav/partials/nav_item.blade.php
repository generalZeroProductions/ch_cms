    @php

 $navKey = Session::get('navKey');
    @endphp
      @if ($navKey === $nav->index)
            <li class="nav-item active">
            @else
        <li class=" nav-item">
            @endif
        <a href="/{{$nav->route}}" class="nav-link" >
            <span class="menu-name">{{ $nav->title }}</span>
        </a>
    </li>
