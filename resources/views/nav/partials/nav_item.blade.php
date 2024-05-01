    <li class="nav-item {{ $loop->first ? 'active' : '' }}">
        <a href="#" class="nav-link" onClick="loadPageFromNav('{{ $nav->route }}')">
            <span class="menu-name">{{ $nav->title }}</span>
        </a>
    </li>
