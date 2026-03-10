{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo y nombre del instituto -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('logos/logo_CarlesVallbona.png') }}" 
                             alt="Institut Carles Vallbona" 
                             class="h-10 w-auto">
                        <div class="hidden md:block">
                            <div class="font-bold text-gray-800">Institut Carles Vallbona</div>
                            <div class="text-sm text-gray-600">CFGS d'Informàtica</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('alumnes.index')" :active="request()->routeIs('alumnes.*')">
                        {{ __('Alumnes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('professors.index')" :active="request()->routeIs('professors.*')">
                        {{ __('Professors') }}
                    </x-nav-link>
                    <x-nav-link :href="route('moduls.index')" :active="request()->routeIs('moduls.*')">
                        {{ __('Mòduls') }}
                    </x-nav-link>
                    <x-nav-link :href="route('grups.index')" :active="request()->routeIs('grups.*')">
                        {{ __('Grups') }}
                    </x-nav-link>
                </div>
                @endauth
            </div>

            <!-- Right side (login/logout) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <!-- Usuario autenticado -->
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        
                        <!-- Logout form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                @else
                    <!-- Usuario NO autenticado -->
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-gray-600 hover:text-gray-900">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" 
                           class="text-gray-600 hover:text-gray-900">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- menu for mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation Menu (mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <!-- Mobile menu para autenticados -->
                <x-responsive-nav-link :href="route('alumnes.index')" :active="request()->routeIs('alumnes.*')">
                    {{ __('Alumnes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('professors.index')" :active="request()->routeIs('professors.*')">
                    {{ __('Professors') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('moduls.index')" :active="request()->routeIs('moduls.*')">
                    {{ __('Mòduls') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('grups.index')" :active="request()->routeIs('grups.*')">
                    {{ __('Grups') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>