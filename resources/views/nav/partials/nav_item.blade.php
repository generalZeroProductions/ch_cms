    <li class="nav-item {{ $key === 0 ? 'active' : '' }}"> 
      {{-- <li class="nav-item"> --}}
        <a href="#" class="nav-link" onClick="loadPageFromNav('{{ $nav->route }}')">
            <span class="menu-name">{{ $nav->title }}</span>
        </a>
    </li>
