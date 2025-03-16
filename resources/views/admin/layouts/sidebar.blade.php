<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-joystick'></i>
        <span class="text">Bookings ID</span>
    </a>
    <ul class="side-menu top">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.playstation') ? 'active' : '' }}">
            <a href="{{ route('admin.playstation') }}">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Collection Playstation</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.booking') ? 'active' : '' }}">
            <a href="{{ route('admin.booking') }}">
                <i class='bx bxs-doughnut-chart'></i>
                <span class="text">Bookings</span>
            </a>
        </li>
        {{-- <li class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}">
            <a href="#">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Message</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.team') ? 'active' : '' }}">
            <a href="#">
                <i class='bx bxs-group'></i>
                <span class="text">Team</span>
            </a>
        </li> --}}
    </ul>
    <ul class="side-menu">
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="{{ route('logout') }}" class="logout"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </form>
        </li>
        <li>
            <a href="{{ route('index') }}">
                <i class='bx bxs-home'></i>
                <span class="text">Customer Page</span>
            </a>
        </li>
    </ul>
</section>
