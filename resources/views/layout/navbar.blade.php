@if (Route::has('login'))
    @auth
        <nav id="navbar-example2" class="navbar navbar-light bg-light px-3">
            <a class="navbar-brand" href="{{ route('home') }}">User Contact Management</a>
            <ul class="nav nav-pills badge-info">
                <li class="nav-item bg">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ url('Showcontact') }}">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">More</a>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" class="btn btn-secondary" style="width: 170px">{{ Auth::user()->name }}
                            </button>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('country-crud') }}">Country</a></li>
                        <li><a class="dropdown-item" href="{{ url('state-crud') }}">State</a></li>
                        <li><a class="dropdown-item" href="{{ url('city-crud') }}">City</a></li>
                        <li><a class="dropdown-item" href="{{ url('user-crud') }}">User</a></li>
                        <li><a class="dropdown-item" href="{{ url('member-ajax-crud') }}">Member</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item badge-info" href="{{ route('change-password') }}">Change
                                Password</a>
                        </li>
                        <li><a class="dropdown-item badge-danger" href="{{ route('logout') }}">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    @else
        <button class="btn btn-light "><a href="{{ url('login') }}"
                class="text-sm text-gray-700 dark:text-gray-500 underline">Login</a></button>
        @if (Route::has('register'))
            <button class="btn btn-light"><a href="{{ route('register') }}"
                    class="text-sm text-gray-700 dark:text-gray-500 underline">Register</a></button>
        @endif
    @endauth
@endif
