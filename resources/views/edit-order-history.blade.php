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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Order History</h2>
                </div>

                <form method="POST" action="{{ route('orders-history.update', $order) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number <span class="text-red-500">*</span></label>
                        <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('invoice_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number</label>
                        <input type="text" name="po_number" id="po_number" value="{{ old('po_number', $order->po_number) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('po_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount', $order->total_amount) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('total_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date <span class="text-red-500">*</span></label>
                        <input type="date" name="order_date" id="order_date" value="{{ old('order_date', $order->order_date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('order_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Customer <span class="text-red-500">*</span></label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">Select Customer</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->NIK }} - {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('orders-history') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</a>
                        <button type="submit" class="bg-[#e05534] hover:bg-[#c04424] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>