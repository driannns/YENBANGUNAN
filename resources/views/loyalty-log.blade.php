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
                                <x-dropdown-link :href="route('loyalty.promotion-program')">
                                    {{ __('Redeem Points') }}
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
                    <h2 class="text-2xl font-bold text-gray-900">Loyalty Log</h2>
                </div>

                <div class="p-6" x-data="{ tab: 'generated' }">
                    <div class="flex items-center gap-2 mb-6">
                        <button type="button" class="px-4 py-2 rounded-md font-semibold"
                                @click="tab = 'generated'"
                                :class="tab === 'generated' ? 'bg-[#e05534] text-white' : 'bg-gray-200 text-gray-700'">
                            Loyalty Log Generated
                        </button>
                        <button type="button" class="px-4 py-2 rounded-md font-semibold"
                                @click="tab = 'redeem'"
                                :class="tab === 'redeem' ? 'bg-[#e05534] text-white' : 'bg-gray-200 text-gray-700'">
                            Loyalty Redeem
                        </button>
                    </div>

                    <div x-show="tab === 'generated'">
                        <!-- Search Form -->
                        <div class="mb-6">
                            <form method="GET" action="{{ route('loyalty.log') }}" class="flex gap-4 flex-wrap">
                                <div class="flex-1 min-w-0">
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           placeholder="Search by customer name, NIK, invoice number, points, or date (YYYY-MM-DD)" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <input type="text" name="phone_number" value="{{ request('phone_number') }}" 
                                           placeholder="Search by phone number" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Search
                                </button>
                                @if(request('search') || request('phone_number'))
                                    <a href="{{ route('loyalty.log') }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Clear
                                    </a>
                                @endif
                            </form>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created Date
                                        </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    @if(auth()->user()->is_admin || auth()->user()->is_manager)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                        </th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Points Generated
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expired Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($loyaltyHistories as $history)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $history->created_at->format('d M Y H:i') }}
                                        </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>
                                            <div class="font-medium">{{ $history->order->invoice_number ?? '-' }}</div>
                                            <div class="text-gray-500">{{ $history->order->po_number ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $history->type === 'redeem' ? 'Redeem' : 'Plus Point' }}
                                    </td>
                                        @if(auth()->user()->is_admin || auth()->user()->is_manager)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                <div class="font-medium">{{ $history->user->name }} - {{ $history->user->phone_number }}</div>
                                                <div class="text-gray-500">{{ $history->user->NIK }}</div>
                                            </div>
                                        </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ $history->order ? number_format($history->order->total_amount, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                            {{ number_format($history->points_earned, 1) }} points
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{ $history->expired_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($loyaltyHistories->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No loyalty history found.</p>
                        </div>
                        @endif
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $loyaltyHistories->links() }}
                        </div>
                    </div>

                    <div x-show="tab === 'redeem'">
                        @if(auth()->user()->is_manager || auth()->user()->is_admin)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4">Pending Redeem Requests</h3>
                            @if(isset($redeemRequests) && $redeemRequests->isNotEmpty())
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach($redeemRequests as $req)
                                        <div class="p-4 border rounded-md bg-white flex items-center justify-between">
                                            <div>
                                                <div class="font-medium">{{ $req->user->name }} — {{ $req->redeemItem->name }} (x{{ $req->quantity }})</div>
                                                <div class="text-sm text-gray-500">Points: {{ number_format($req->points_used, 0, ',', '.') }} — Submitted: {{ $req->created_at->format('d M Y H:i') }}</div>
                                                @php
                                                    $s = strtolower($req->status);
                                                    if ($s === 'pending') {
                                                        $c = 'bg-yellow-100 text-yellow-800';
                                                    } elseif ($s === 'redeemed') {
                                                        $c = 'bg-green-100 text-green-800';
                                                    } elseif ($s === 'rejected') {
                                                        $c = 'bg-red-100 text-red-800';
                                                    } elseif ($s === 'cancelled') {
                                                        $c = 'bg-gray-100 text-gray-800';
                                                    } else {
                                                        $c = 'bg-gray-100 text-gray-800';
                                                    }
                                                @endphp
                                                <div class="mt-1"><span class="px-2 py-1 rounded text-sm font-semibold {{ $c }}">{{ ucfirst($req->status) }}</span></div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <form method="POST" action="{{ route('loyalty.redeem.approve', $req->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Approve</button>
                                                </form>
                                                <form method="POST" action="{{ route('loyalty.redeem.reject', $req->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No pending redeem requests.</p>
                            @endif
                        </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Submitted Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item
                                        </th>
                                        @if(auth()->user()->is_admin || auth()->user()->is_manager)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Points Used
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Processed Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($redeemHistories as $redeem)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $redeem->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                <div class="font-medium">{{ $redeem->redeemItem->name ?? 'Item' }}</div>
                                                <div class="text-gray-500">Qty: {{ $redeem->quantity }}</div>
                                            </div>
                                        </td>
                                        @if(auth()->user()->is_admin || auth()->user()->is_manager)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                <div class="font-medium">{{ $redeem->user->name }} - {{ $redeem->user->phone_number }}</div>
                                                <div class="text-gray-500">{{ $redeem->user->NIK }}</div>
                                            </div>
                                        </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($redeem->points_used, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @php
                                                $s = strtolower($redeem->status);
                                                if ($s === 'pending') {
                                                    $c = 'bg-yellow-100 text-yellow-800';
                                                } elseif ($s === 'redeemed') {
                                                    $c = 'bg-green-100 text-green-800';
                                                } elseif ($s === 'rejected') {
                                                    $c = 'bg-red-100 text-red-800';
                                                } elseif ($s === 'cancelled') {
                                                    $c = 'bg-gray-100 text-gray-800';
                                                } else {
                                                    $c = 'bg-gray-100 text-gray-800';
                                                }
                                            @endphp
                                            <span class="px-2 py-1 rounded text-sm font-semibold {{ $c }}">{{ ucfirst($redeem->status) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $redeem->processed_at ? $redeem->processed_at->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($redeemHistories->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No redeem history found.</p>
                        </div>
                        @endif
                        <div class="mt-4">
                            {{ $redeemHistories->links() }}
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('orders-history') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to Orders</a>
                        <a href="{{ route('loyalty.formula') }}" class="bg-[#e05534] hover:bg-[#c04424] text-white font-bold py-2 px-4 rounded">View Formula</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
