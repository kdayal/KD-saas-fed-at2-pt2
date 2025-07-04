<nav x-data="{ open: false }" class="bg-gray-900 text-gray-200 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-200"/>
                        </a>
                    @else
                        <a href="{{ route('home') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-200"/>
                        </a>
                    @endauth

                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <i class="fa-solid fa-home mr-1"></i>
                        {{ __('Home') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <i class="fa-solid fa-laptop mr-1"></i>
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        @can('viewAny', App\Models\User::class)
                            {{-- Users Link - visible only to authorized users --}}
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                                <i class="fa-solid fa-users mr-1"></i>
                                {{ __('Users') }}
                            </x-nav-link>
                        @endcan

                        {{-- Added Jokes Link --}}
                        <x-nav-link :href="route('jokes.index')" :active="request()->routeIs('jokes.*')">
                            <i class="fa-solid fa-face-laugh-beam mr-1"></i>
                            {{ __('Jokes') }}
                        </x-nav-link>

                        @hasrole('Administrator') {{-- Or @can('Roles & Permissions') --}}
                            <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                                <i class="fa-solid fa-shield-halved mr-1"></i>
                                {{ __('Manage Roles') }}
                             </x-nav-link>

                            {{-- Added Manage Categories Link (Admin Only) --}}
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                <i class="fa-solid fa-tags mr-1"></i> {{-- Using tags icon for categories --}}
                                {{ __('Manage Categories') }}
                            </x-nav-link>
                        @endhasrole

                        {{-- Removed redundant 'Other Links' for authenticated users --}}

                    @else
                        {{-- 'Other Links' for unauthenticated users --}}
                        <x-nav-link :href="route('home')" :active="request()->routeIs('other.*')"> {{-- You might want to change this route if 'other.*' is not home --}}
                            <i class="fa-solid fa-link mr-1"></i>
                            {{ __('Other Links') }} ({{ __('Unauthenticated') }})
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <i class="fa-solid fa-user mr-1"></i>
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fa-solid fa-user-edit mr-1"></i>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <i class="fa-solid fa-door-closed mr-1"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                @else

                    <a href="{{ route('login') }}"
                       class="inline-block px-5 py-1.5 dark:text-gray-200 text-gray-400 border border-transparent hover:border-gray-500 dark:hover:border-gray-400 rounded-sm text-sm leading-normal"
                    >
                        <i class="fa-solid fa-door-open mr-1"></i>
                        {{ __("Log in") }}
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-gray-200 border-gray-300 hover:border-gray-500 border text-gray-400 dark:border-gray-400 dark:hover:border-gray-400 rounded-sm text-sm leading-normal">
                            <i class="fa-solid fa-id-card mr-1"></i>
                            {{ __("Register") }}
                        </a>
                    @endif

                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                <i class="fa-solid fa-home mr-1"></i>
                {{ __('Home') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="fa-solid fa-laptop mr-1"></i>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @can('viewAny', App\Models\User::class)
                    {{-- Users Responsive Link - visible only to authorized users --}}
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        <i class="fa-solid fa-users mr-1"></i>
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                @endcan

                {{-- Added Jokes Responsive Link --}}
                <x-responsive-nav-link :href="route('jokes.index')" :active="request()->routeIs('jokes.*')">
                    <i class="fa-solid fa-face-laugh-beam mr-1"></i>
                    {{ __('Jokes') }}
                </x-responsive-nav-link>

                @hasrole('Administrator') {{-- Or @can('Roles & Permissions') --}}
                    <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        <i class="fa-solid fa-shield-halved mr-1"></i>
                        {{ __('Manage Roles') }}
                    </x-responsive-nav-link>

                    {{-- Added Manage Categories Responsive Link (Admin Only) --}}
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        <i class="fa-solid fa-tags mr-1"></i> {{-- Using tags icon for categories --}}
                        {{ __('Manage Categories') }}
                    </x-responsive-nav-link>
                @endhasrole

                {{-- Removed redundant 'Other Links' for authenticated users --}}

            @else

                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('other.*')"> {{-- You might want to change this route if 'other.*' is not home --}}
                    <i class="fa-solid fa-link mr-1"></i>
                    {{ __('Other Links') }} ({{ __('Unauthenticated') }})
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    <i class="fa-solid fa-door-open mr-1"></i>
                    Log in
                </x-responsive-nav-link>

                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        <i class="fa-solid fa-id-card mr-1"></i>
                        Register
                    </x-responsive-nav-link>
                @endif
            @endauth

            {{-- Removed redundant 'Other Links' for general users --}}
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        <i class="fa-solid fa-user-edit mr-1"></i>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            <i class="fa-solid fa-door-closed mr-1"></i>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
