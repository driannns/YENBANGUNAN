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
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" style="margin-right: 0 !important; color: black;">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('product')" :active="request()->routeIs('product')" style="margin-right: 0 !important; color: black;">
                            {{ __('Product') }}
                        </x-nav-link>
                        <x-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')" style="color: black; margin-right: 0 !important;">
                            {{ __('About Us') }}
                        </x-nav-link>
                        <x-nav-link :href="route('blog')" :active="request()->routeIs('blog')" style="color: black; margin-right: 0 !important;">
                            {{ __('Blog') }}
                        </x-nav-link>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:justify-end gap-2 sm:ms-6 w-4/12">
                        <a href="https://wa.me/6282123269622" class="@auth w-2/3 @else w-1/2 @endauth text-center bg-[#e05534] border border-[#e05534] text-white px-4 py-2 rounded-full text-xs uppercase font-mono font-bold">Kebutuhan Projek</a>
                        @auth
                        <x-dropdown align="right" class="">
                            <x-slot name="trigger" class="w-fit">
                                <button class="bg-white px-2 text-gray-500 flex gap-1 items-center justify-between px- py-2 border border-transparent text-sm leading-4 font-medium rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <img class="w-2/12" src="{{asset('assets/user.png')}}" alt="">
                                    <div class="text-xs">{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('orders-history')">
                                    {{ __('Order History') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('loyalty.promotion-program')">
                                    {{ __('Loyalty Program') }}
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
                        @else
                        <div class="flex items-center gap-1">
                            <a href="{{ route('login') }}" class="py-1 px-3 font-d-din rounded-full bg-[#e05534] text-white font-bold">Login</a>
                        </div>
                        @endauth
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
                        <a href="{{ route('loyalty.promotion-program') }}" class="text-3xl mt-1 font-bold text-white hover:text-gray-200">{{ number_format($loyaltyPoints, 0, ',', '.') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex items-center mt-4 justify-end w-full gap-2 mb-4">
            @if(auth()->user()->is_admin)
            <a href="{{ route('orders-history.create') }}" class="bg-[#e05534] text-white px-4 py-2 rounded-full w-fit mb-0">Create</a>
            @endif
            @if(auth()->user()->is_manager or auth()->user()->is_admin)
            <a href="{{ route('loyalty.log') }}" class="bg-blue-500 text-white px-4 py-2 rounded-full w-fit" style="margin-top: 0 !important;">Loyalty Log</a>
            @endif
        </div>

        <!-- Search Form -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('orders-history') }}" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search by invoice number, customer name, NIK, PO number, amount, status, or date (YYYY-MM-DD)" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('orders-history') }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Clear
                        </a>
                    @endif
                </form>
            </div>
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
                    @elseif(auth()->user()->is_manager && $order->status === 'void_requested')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('orders-history.void-approve', $order) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md text-white font-medium transition-all" onclick="return confirm('Approve void for this order?')">
                                Approve Void
                            </button>
                        </form>
                        <form method="POST" action="{{ route('orders-history.void-reject', $order) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white font-medium transition-all" onclick="return confirm('Reject void request for this order?')">
                                Reject Void
                            </button>
                        </form>
                    </div>
                    @elseif(auth()->user()->is_admin && !auth()->user()->is_manager)
                    <div class="flex gap-2">
                        <a href="{{ route('orders-history.edit', $order) }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md text-white font-medium transition-all">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('orders-history.destroy', $order) }}" class="inline" onsubmit="return confirm('Submit void request for this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white font-medium transition-all {{ $order->status !== 'confirmed' ? 'opacity-50 cursor-not-allowed' : '' }}" @if($order->status !== 'confirmed') disabled @endif>
                                Void
                            </button>
                        </form>
                    </div>
                    @else
                    <div></div>
                    @endif
                    @if(auth()->user()->is_admin || auth()->user()->is_manager)
                    <div class="flex items-center gap-4 p-1 rounded-full bg-gray-300">
                        <div class="py-1 px-3 rounded-full @if($order->status === 'draft') bg-[#e05534] text-white  @endif">Draft</div>
                        <div class="py-1 px-3 rounded-full @if($order->status === 'confirmed') bg-[#e05534] text-white  @endif">Confirmed</div>
                        @if($order->status === 'rejected')
                        <div class="py-1 px-3 rounded-full @if($order->status === 'rejected') bg-[#e05534] text-white @endif">Rejected</div>
                        @endif
                        @if($order->status === 'void_requested')
                        <div class="py-1 px-3 rounded-full @if($order->status === 'void_requested') bg-[#e05534] text-white @endif">Void Requested</div>
                        @endif
                        @if($order->status === 'voided')
                        <div class="py-1 px-3 rounded-full @if($order->status === 'voided') bg-[#e05534] text-white @endif">Voided</div>
                        @endif
                    </div>
                    @endif
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
