@php

@endphp
  
  <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="/{{$nav->route}}" id="{{ $nav->title }}Dropdown" role="button"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ $nav->title }}
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          @foreach ($subs as $subNav)
              <a class="dropdown-item" href="{{$subNav->route}}">{{ $subNav->title }}</a>
          @endforeach
      </div>
  </li>
