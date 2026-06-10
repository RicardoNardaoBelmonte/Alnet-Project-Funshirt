<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('home') }}" wire:navigate />

            <flux:navbar class="mx-auto max-lg:hidden">
                <flux:navbar.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    Home
                </flux:navbar.item>
                <flux:navbar.item :href="route('categories.index')" :current="request()->routeIs('categories.*')" wire:navigate>
                    Categories
                </flux:navbar.item>
                @auth
                    <flux:navbar.item :href="route('my.tshirts.index')" :current="request()->routeIs('my.tshirts.*')" wire:navigate>
                        Personalized
                    </flux:navbar.item>
                @else
                    <flux:navbar.item :href="route('login')" :current="false">
                        Personalized
                    </flux:navbar.item>
                @endauth
                <flux:navbar.item :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                    About Us
                </flux:navbar.item>
                <flux:navbar.item :href="route('support')" :current="request()->routeIs('support')" wire:navigate>
                    Support
                </flux:navbar.item>
                @can('admin')
                    <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard') || request()->routeIs('admin.*')" wire:navigate>
                        Admin
                    </flux:navbar.item>
                @endcan
            </flux:navbar>

            <flux:spacer />

            <div class="flex items-center gap-3">
                {{-- Cart icon --}}
                <a href="{{ route('shop.cart.show') }}" class="relative flex items-center justify-center w-9 h-9 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors" wire:navigate>
                    <flux:icon.shopping-cart class="w-5 h-5 text-zinc-600 dark:text-zinc-300" />
                    @php $cartCount = count(session('tshirt_cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-amber-400 text-[10px] font-bold text-zinc-900 leading-none">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <x-desktop-user-menu class="hidden lg:block" />
                @else
                    <flux:navbar.item icon="user" :href="route('login')" :label="__('Login')" wire:navigate />
                @endauth
            </div>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Navigation')">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        Home
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" :href="route('categories.index')" :current="request()->routeIs('categories.*')" wire:navigate>
                        Categories
                    </flux:sidebar.item>
                    @auth
                        <flux:sidebar.item icon="sparkles" :href="route('my.tshirts.index')" :current="request()->routeIs('my.tshirts.*')" wire:navigate>
                            Personalized
                        </flux:sidebar.item>
                    @else
                        <flux:sidebar.item icon="sparkles" :href="route('login')" wire:navigate>
                            Personalized
                        </flux:sidebar.item>
                    @endauth
                    <flux:sidebar.item icon="information-circle" :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                        About Us
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="question-mark-circle" :href="route('support')" :current="request()->routeIs('support')" wire:navigate>
                        Support
                    </flux:sidebar.item>
                    @can('admin')
                        <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            Dashboard
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="shopping-bag" :href="route('admin.tshirts.index')" :current="request()->routeIs('admin.tshirts.*')" wire:navigate>
                            T-Shirts
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="tag" :href="route('admin.categories.index')" :current="request()->routeIs('admin.categories.*')" wire:navigate>
                            Categories
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="swatch" :href="route('admin.colors.index')" :current="request()->routeIs('admin.colors.*')" wire:navigate>
                            Colors
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                            Users
                        </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                @auth
                    <flux:sidebar.item icon="cog" :href="route('profile.edit')" :current="request()->routeIs('profile.edit')" wire:navigate>
                        Settings
                    </flux:sidebar.item>
                @else
                    <flux:sidebar.item icon="user" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                        Login
                    </flux:sidebar.item>
                @endauth
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
