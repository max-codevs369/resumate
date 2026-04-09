<nav>
    <div class="nav-container">
        <a href="{{ url('/') }}" class="logo">
            <svg class="logo-icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 6C6 3.79086 7.79086 2 10 2H20L28 10V28C28 30.2091 26.2091 32 24 32H10C7.79086 32 6 30.2091 6 28V6Z" fill="var(--primary-color)"/>
                <path d="M20 2V8C20 9.10457 20.8954 10 22 10H28L20 2Z" fill="var(--primary-hover)"/>
                <rect x="10" y="14" width="12" height="2" rx="1" fill="white" fill-opacity="0.9"/>
                <rect x="10" y="19" width="12" height="2" rx="1" fill="white" fill-opacity="0.9"/>
                <rect x="10" y="24" width="8" height="2" rx="1" fill="white" fill-opacity="0.9"/>
            </svg>
            <span>{{ config('app.name', 'ResuMate') }}</span>
        </a>

        <div class="nav-right">
            <ul class="nav-menu" id="navMenu">
                <li>
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('templates') }}" class="{{ request()->routeIs('template*') ? 'active' : '' }}">
                        Templates
                    </a>
                </li>
                @auth
                    @if(auth()->user()->is_premium == 0)
                        <li>
                            <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing', 'user.checkout') ? 'active' : '' }}">
                                Pricing
                            </a>
                        </li>
                    @endif
                @endauth

                @guest
                    <li>
                        <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing', 'user.checkout') ? 'active' : '' }}">
                            Pricing
                        </a>
                    </li>
                @endguest

                @auth
                    <li>
                        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard*', 'user.profile*', 'user.resumes*') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="btn-register {{ request()->routeIs('register') ? 'active' : '' }}">
                            Register Now →
                        </a>
                    </li>
                @endauth
            </ul>

            @auth
            <div class="nav-profile" id="navProfile">
                <button class="nav-avatar-btn" id="profileToggle" aria-label="User menu" title="{{ auth()->user()->name }}">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </button>

                <div class="profile-dropdown" id="profileDropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-name">{{ auth()->user()->name }}</div>
                        <div class="dropdown-email">{{ auth()->user()->email }}</div>
                    </div>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('user.profile.show', Auth::user()->id) }}">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                        </li>
                       
                        <li class="dropdown-divider" role="separator"></li>

                        <li class="logout-item">
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit">
                                    <i class="fas fa-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endauth

            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>

