@php
use App\Models\Navigation;

@endphp
  
  <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="{{ $nav->title }}Dropdown" role="button"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
