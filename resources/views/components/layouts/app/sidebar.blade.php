<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="tag"
                    :href="route('products.catalog')"
                    :current="request()->routeIs('products.catalog')"
                    wire:navigate>
                    {{ __('Catalog') }}
                </flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('products.index')"
                    :current="request()->routeIs('products.index')"
                    wire:navigate>Products</flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('cart.show')"
                    :current="request()->routeIs('cart.show')"
                    wire:navigate>Cart</flux:navlist.item>
                @auth
                <flux:navlist.item icon="tag" :href="route('categories.index')"
                    :current="request()->routeIs('categories.index')"
                    wire:navigate>Categories</flux:navlist.item>
                @can('employee')

                <flux:navlist.item icon="tag" :href="route('stock_adjustments.index')"
                    :current="request()->routeIs('stock_adjustments.index')"
                    wire:navigate>Stock Adjustments</flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('supply_orders.index')"
                    :current="request()->routeIs('supply_orders.index')"
                    wire:navigate>Supply orders</flux:navlist.item>
                @endcan
                @can('admin')

                <flux:navlist.item icon="tag" :href="route('membership_fees.edit')"
                    :current="request()->routeIs('membership_fees.edit')"
                    wire:navigate>Membership Fee</flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('shipping_costs.index')"
                    :current="request()->routeIs('shipping_costs.index')"
                    wire:navigate>Shipping Costs</flux:navlist.item>
                @endcan
                @can('employee')
                <flux:navlist.item icon="tag" :href="route('users.index')"
                    :current="request()->routeIs('users.index')"
                    wire:navigate>Users</flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('cards.index')"
                    :current="request()->routeIs('cards.index')"
                    wire:navigate>Cards</flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('operations.index')"
                    :current="request()->routeIs('operations.index')"
                    wire:navigate>Operations</flux:navlist.item>
                @endcan

                <flux:navlist.item icon="tag" :href="route('cards.mycard')"
                    :current="request()->routeIs('cards.mycard')"
                    wire:navigate>Card</flux:navlist.item>

                <flux:navlist.item icon="tag" :href="route('operations.mycard')"
                    :current="request()->routeIs('operations.mycard')"
                    wire:navigate>MyOperations</flux:navlist.item>


@can('employee')


                <flux:navlist.item icon="tag" :href="route('orders.index')"
                    :current="request()->routeIs('orders.index')"
                    wire:navigate>Orders</flux:navlist.item>
@endcan




                <flux:navlist.item icon="chart-bar" :href="route('statistics.index')" :current="request()->routeIs('statistics.index')" wire:navigate>
                    Statistics
                </flux:navlist.item>


            </flux:navlist.group>





        </flux:navlist>

        @endauth
        <flux:spacer />
        <!--
        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>
    -->
        @auth
        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>
    @endauth
    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @fluxScripts
</body>

</html>
