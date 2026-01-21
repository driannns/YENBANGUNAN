<x-app-layout>
    <nav x-data="{ open: false }" class="bg-white text-black">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 w-2/12 md:w-1/2 lg:w-3/12 flex items-center">
                        <a href="{{ route('dashboard') }}" class="w-4/12 invert">
                            <x-application-logo class="block w-10 fill-current" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="w-1/2 items-center justify-center hidden space-x-8 sm:-my-px sm:ms-10 sm:flex font-d-din uppercase">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" style="color: black;">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('product')" :active="request()->routeIs('product')" style="color: black;">
                            {{ __('Product') }}
                        </x-nav-link>
                        <x-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')" style="color: black;">
                            {{ __('About Us') }}
                        </x-nav-link>
                        <x-nav-link :href="route('blog')" :active="request()->routeIs('blog')" style="color: black;">
                            {{ __('Blog') }}
                        </x-nav-link>
                    </div>

                    <div class="hidden sm:flex sm:items-center gap-2 sm:ms-6 w-3/12">
                        <div class="w-full">
                            <button class="w-full bg-[#e05534] border border-[#e05534] text-white px-4 py-2 rounded-full text-xs uppercase font-mono font-bold">Kebutuhan Projek</button>
                        </div>
                        <x-dropdown align="right">
                            <x-slot name="trigger" class="w-fit">
                                @auth
                                <button class="bg-white px-2 text-gray-500 flex gap-1 items-center justify-between px- py-2 border border-transparent text-sm leading-4 font-medium rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <img class="w-2/12" src="{{asset('assets/user.png')}}" alt="">
                                    <div class="text-xs">{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                                @else
                                <div class="flex items-center gap-1">
                                    <button class="py-1 px-3 font-d-din rounded-full bg-[#e05534] text-white font-bold">Login</button>
                                    <button class="py-1 px-3 font-d-din rounded-full bg-[#e05534] text-white font-bold">Register</button>
                                </div>
                                    @endauth
                            </x-slot>
        
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('orders-history')">
                                    {{ __('Order History') }}
                                </x-dropdown-link>
                                @if(auth()->user()->is_manager)
                                <x-dropdown-link :href="route('loyalty.log')">
                                    {{ __('Loyalty Log') }}
                                </x-dropdown-link>
                                @endif
        
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
        
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <!-- Settings Dropdown -->

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('product')" :active="request()->routeIs('product')">
                    {{ __('Product') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')">
                    {{ __('About Us') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('blog')" :active="request()->routeIs('blog')">
                    {{ __('Blog') }}
                </x-responsive-nav-link>
                <hr>
                <x-responsive-nav-link :href="route('blog')" :active="request()->routeIs('blog')">
                    {{ __('Kebutuhan Project') }}
                </x-responsive-nav-link>
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
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

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
            </div>
            @endauth
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex flex-col gap-3">
            <div class="">
                <div class="flex items-center gap-4">
                    <div class="w-full bg-[#e05534] shadow sm:rounded-lg text-white p-4 font-d-din hover:scale-105 transition-transform cursor-pointer">
                        <h1 class="text-lg font-medium">Total Pembelian</h1>
                        <h1 class="text-3xl mt-1 font-bold">Rp {{ number_format($orderAmount, 0, ',', '.') }}</h1>
                    </div>
                    <div class="w-full bg-[#e05534] shadow sm:rounded-lg text-white p-4 font-d-din hover:scale-105 transition-transform cursor-pointer">
                        <h1 class="text-lg font-medium">Total Point</h1>
                        <a href="{{ route('loyalty.formula') }}" class="text-3xl mt-1 font-bold">{{ number_format(14520, 0, ',', '.') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex mt-4 justify-end w-full gap-2">
            <a href="{{ route('loyalty.log') }}" class="bg-blue-500 text-white px-4 py-2 rounded-full w-fit">Loyalty Log</a>
            <a href="{{ route('orders-history.create') }}" class="bg-[#e05534] text-white px-4 py-2 rounded-full w-fit">Create</a>
        </div>
        @if(session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex flex-col mt-4">
            @foreach($orders as $order)
            <div class="p-2 sm:p-4 bg-white shadow sm:rounded-lg">
                <div class="flex justify-between items-center">
                    @if(auth()->user()->is_manager && $order->status === 'draft')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('orders-history.approve', $order) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md text-white font-medium transition-all">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('orders-history.reject', $order) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white font-medium transition-all" onclick="return confirm('Are you sure you want to reject this order?')">
                                Reject
                            </button>
                        </form>
                    </div>
                    @elseif(auth()->user()->is_admin && !auth()->user()->is_manager)
                    <div class="flex gap-2">
                        <a href="{{ route('orders-history.edit', $order) }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md text-white font-medium transition-all">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('orders-history.destroy', $order) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white font-medium transition-all">
                                Void
                            </button>
                        </form>
                    </div>
                    @else
                    <div></div>
                    @endif
                    <div class="flex items-center gap-4 p-1 rounded-full bg-gray-300">
                         @if($order->status === 'draft')
                         <div class="py-1 px-3 bg-yellow-400 rounded-full">Draft</div>
                         @elseif($order->status === 'confirmed')
                         <div class="py-1 px-3 bg-green-400 rounded-full">Confirmed</div>
                         @elseif($order->status === 'rejected')
                         <div class="py-1 px-3 bg-red-400 rounded-full">Rejected</div>
                         @endif
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="w-4/12">
                        <h1 class="text-2xl font-semibold">{{ $order->invoice_number }}</h1>
                        <p class="text-sm text-gray-400">{{ $order->created_at }}</p>
                    </div>
                    @if(auth()->user()->is_admin || auth()->user()->is_manager)
                    <div class="w-4/12">
                        <h1 class="text-sm font-bold">Customer Name:</h1>
                        <p class="font-bold">{{ $order->user->name }}</p>
                        <p class="text-xs font-medium">{{ $order->user->NIK }}</p>
                    </div>
                    @endif
                    <div class="w-4/12">
                        <h1 class="text-sm mt-1 font-bold">PO Number</h1>
                        <p>{{ $order->po_number }}</p>
                    </div>
                    <div class="w-4/12 flex flex-col items-end">
                        <h1>Total Amount</h1>
                        <h1 class="text-lg mt-1 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h1>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>