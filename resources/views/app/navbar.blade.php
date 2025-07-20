<div class="top-bar">
    <div class="breadcrumb" id="breadcrumb"></div>
    
    <div class="user-info">
        <span>{{ Auth::user()->name ?? 'User' }}</span>
        <div class="user-avatar" onclick="toggleDropdownNavbar()">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}" alt="avatar">
            <div class="dropdown-menu" id="dropdown-menu">
                <a href="">Profile</a>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>
