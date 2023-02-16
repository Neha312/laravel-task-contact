@if (Route::has('login'))
    @auth
        <nav id="navbar-example2" class="navbar navbar-light bg-light px-3">
            <a class="navbar-brand" href="{{ route('home') }}"><i class="lar la-address-book" style="font-size: 24px"></i> User
                Contact Management</a>
            <ul class="nav nav-pills badge-info">
                <li class="nav-item bg">
                    <a class="nav-link" href="{{ route('home') }}"><i class="las la-home" style="font-size: 20px"></i>
                        Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ url('Showcontact') }}"><i class="lar la-address-book"
                            style="font-size: 20px"></i> Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false"><i class="las la-caret-down" style="font-size: 20px"></i>More</a>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" class="btn btn-secondary" style="width: 170px">{{ Auth::user()->name }}
                            </button>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('country-crud') }}"><i class="las la-city"
                                    style="font-size: 24px"></i>
                                Country</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('state-crud') }}"><i class="las la-city"
                                    style="font-size: 24px"></i> State</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('city-crud') }}"><i class="las la-city"
                                    style="font-size: 24px"></i> City</a></li>
                        <li><a class="dropdown-item" href="{{ url('user-crud') }}"><i class="las la-user-circle"
                                    style="font-size: 24px"></i>
                                User</a></li>
                        <li><a class="dropdown-item" href="{{ url('member-ajax-crud') }}"><i class="las la-user-friends"
                                    style="font-size: 24px"></i> Member</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item badge-info" href="{{ route('change-password') }}"><i class="las la-edit"
                                    style="font-size: 24px"></i> Change
                                Password</a>
                        </li>
                        <li><a class="dropdown-item badge-danger" href="{{ route('logout') }}"><i class="las la-power-off"
                                    style="font-size: 24px"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    @else
        <button class="btn btn-light "><a href="{{ url('login') }}"
                class="text-sm text-gray-700 dark:text-gray-500 underline"><i class="las la-key"
                    style="font-size: 20px"></i> Login</a></button>
        @if (Route::has('register'))
            <button class="btn btn-light"><a href="{{ route('register') }}"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"><i class="las la-user-plus"
                        style="font-size: 20px"></i>
                    Register</a></button>
        @endif
    @endauth
@endif
