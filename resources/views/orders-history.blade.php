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
                        <a href="https://wa.me/6282123269622" target="_blank" class="@auth w-2/3 @else w-1/2 @endauth text-center bg-[#e05534] border border-[#e05534] text-white px-4 py-2 rounded-full text-xs uppercase font-mono font-bold">Kebutuhan Projek</a>
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
                <x-responsive-nav-link href="https://wa.me/6282123269622" target="_blank" :active="request()->routeIs('blog')">
                    {{ __('Kebutuhan Projek') }}
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

    <div x-data="{ openCreate: false }" class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3 flex flex-col gap-2">
            <div class="">
                <div class="flex items-center gap-3">
                    <div class="w-full bg-[#e05534] shadow sm:rounded-lg text-white px-4 py-3 font-d-din hover:scale-105 transition-transform cursor-pointer">
                        <h1 class="text-base sm:text-lg font-medium">Total Pembelian</h1>
                        <h1 class="text-2xl sm:text-3xl mt-1 font-bold">Rp {{ number_format($orderAmount, 0, ',', '.') }}</h1>
                    </div>
                    <a href="{{ route('loyalty.promotion-program') }}" class="w-full bg-[#e05534] shadow sm:rounded-lg text-white px-4 py-3 font-d-din hover:scale-105 transition-transform cursor-pointer">
                        <h1 class="text-base sm:text-lg font-medium">Total Point</h1>
                        <h1 class="text-2xl sm:text-3xl mt-1 font-bold text-white hover:text-gray-200">{{ number_format($loyaltyPoints, 0, ',', '.') }}</h1>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white shadow sm:rounded-lg p-4 sm:p-5 mb-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
                    <div>
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800">Riwayat Pesanan</h2>
                        <p class="text-xs sm:text-sm text-gray-500">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan.</p>
                    </div>
                    <div class="flex flex-col sm:items-end gap-2">
                        @if(request('search'))
                        <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-[#e05534]">
                            Pencarian: "{{ request('search') }}"
                        </span>
                        @endif

                        @if(auth()->user()->is_admin || auth()->user()->is_manager)
                        <div class="flex gap-2 justify-end">
                            @if(auth()->user()->is_admin)
                            <button type="button" @click="openCreate = true" class="bg-[#e05534] text-white px-3 py-1.5 rounded-full text-xs font-semibold">Create</button>
                            @endif
                            <a href="{{ route('loyalty.log') }}" class="bg-blue-500 text-white px-3 py-1.5 rounded-full text-xs font-semibold">Loyalty Log</a>
                        </div>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('orders-history') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari invoice, nama customer, NIK, PO, jumlah, status, atau tanggal (YYYY-MM-DD)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-[#e05534] focus:border-[#e05534] text-sm">
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button type="submit" class="px-5 py-2 bg-[#e05534] text-white rounded-full text-xs font-semibold tracking-wide hover:bg-[#c04424] focus:outline-none focus:ring-2 focus:ring-[#e05534] focus:ring-offset-2">
                            Cari Pesanan
                        </button>
                        @if(request('search'))
                        <a href="{{ route('orders-history') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold tracking-wide hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                            Bersihkan
                        </a>
                        @endif
                    </div>
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

        {{-- Create Order Modal (Admin only) --}}
        @if(auth()->user()->is_admin)
        <div x-cloak x-show="openCreate" class="fixed inset-0 z-40 flex items-center justify-center bg-black/40">
            <div @click.stop class="bg-white rounded-xl shadow-lg w-full max-w-lg p-5">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Create Order</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" @click="openCreate = false">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('orders-history.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Invoice Number <span class="text-red-500">*</span></label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]" required>
                        @error('invoice_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">PO Number</label>
                            <input type="text" name="po_number" value="{{ old('po_number') }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]">
                            @error('po_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Total Amount <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="total_amount" value="{{ old('total_amount') }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]" required>
                            @error('total_amount')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Order Date <span class="text-red-500">*</span></label>
                            <input type="date" name="order_date" value="{{ old('order_date') }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]" required>
                            @error('order_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if(!empty($users))
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Customer <span class="text-red-500">*</span></label>
                        <select name="user_id" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]" required>
                            <option value="">Pilih Customer</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" @selected(old('user_id')==$u->id)>{{ $u->NIK }} - {{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Remarks</label>
                        <textarea name="description" rows="2" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]" placeholder="Catatan tambahan (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-gray-100 mt-2">
                        <button type="button" class="text-xs font-medium text-gray-500 hover:text-gray-700" @click="openCreate = false">Batal</button>
                        <button type="submit" class="px-3 py-1.5 rounded-full bg-[#e05534] text-white text-xs font-semibold">Create Order</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3 flex flex-col items-center mt-4">
            @foreach($orders as $order)
            @php
            $status = $order->status;
            $statusLabel = [
            'draft' => 'Draft - Menunggu Persetujuan',
            'confirmed' => 'Confirmed',
            'rejected' => 'Rejected',
            'void_requested' => 'Void Requested',
            'voided' => 'Voided',
            ][$status] ?? ucfirst($status);

            $statusClasses = match($status) {
            'confirmed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            'rejected' => 'bg-red-50 text-red-700 border border-red-200',
            'void_requested' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'voided' => 'bg-gray-50 text-gray-700 border border-gray-200',
            default => 'bg-orange-50 text-orange-700 border border-orange-200',
            };

            $displayDate = $order->order_date
            ? \Carbon\Carbon::parse($order->order_date)
            : $order->created_at;
            @endphp

            <div x-data="{ openEdit: false }" class="w-full max-w-4xl p-2 sm:p-3 bg-white shadow-sm sm:rounded-xl border-l-4 @if($status === 'confirmed') border-l-emerald-500 @elseif($status === 'rejected') border-l-red-500 @elseif($status === 'draft') border-l-[#e05534] @elseif($status === 'void_requested') border-l-amber-500 @elseif($status === 'voided') border-l-gray-500 @else border-l-gray-300 @endif">
                @if(auth()->user()->is_admin || auth()->user()->is_manager)
                {{-- Admin / Manager view --}}
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-start gap-2">
                        <div class="flex gap-2 w-48">
                            @if(auth()->user()->is_manager)
                            <button type="button" @click="openEdit = true" class="bg-blue-500 hover:bg-blue-600 px-3 py-1.5 rounded-md text-white text-xs font-medium transition-all whitespace-nowrap">
                                Edit
                            </button>
                            @if($order->status === 'draft')
                            <form method="POST" action="{{ route('orders-history.approve', $order) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 px-3 py-1.5 rounded-md text-white text-xs font-medium transition-all whitespace-nowrap">
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('orders-history.reject', $order) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-md text-white text-xs font-medium transition-all whitespace-nowrap" onclick="return confirm('Are you sure you want to reject this order?')">
                                    Reject
                                </button>
                            </form>
                            @elseif($order->status === 'void_requested')
                            <form method="POST" action="{{ route('orders-history.void-approve', $order) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 px-3 py-1.5 rounded-md text-white text-xs font-medium transition-all whitespace-nowrap" onclick="return confirm('Approve void for this order?')">
                                    Approve Void
                                </button>
                            </form>
                            <form method="POST" action="{{ route('orders-history.void-reject', $order) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-md text-white text-xs font-medium transition-all whitespace-nowrap" onclick="return confirm('Reject void request for this order?')">
                                    Reject Void
                                </button>
                            </form>
                            @endif
                            @elseif(auth()->user()->is_admin && !auth()->user()->is_manager)
                            <button type="button" @click="openEdit = true" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md text-white font-medium transition-all whitespace-nowrap">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('orders-history.destroy', $order) }}" class="inline" onsubmit="return confirm('Submit void request for this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white font-medium transition-all {{ $order->status !== 'confirmed' ? 'opacity-50 cursor-not-allowed' : '' }}" @if($order->status !== 'confirmed') disabled @endif>
                                    Void
                                </button>
                            </form>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-right">
                                <h1 class="text-base sm:text-lg font-semibold text-gray-900">{{ $order->invoice_number }}</h1>
                                <p class="text-[11px] text-gray-400">Tanggal Order: {{ $displayDate->format('d M Y') }}</p>
                                <div class="mt-1 inline-flex items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>
                                    @if($order->status === 'confirmed')
                                    <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span>
                                        Mendapatkan Loyalty Points
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Edit Order Wizard Modal (Admin & Manager) -->
                            @if(auth()->user()->is_admin || auth()->user()->is_manager)
                            <div x-cloak x-show="openEdit" class="fixed inset-0 z-40 flex items-center justify-center bg-black/40">
                                <div @click.stop class="bg-white rounded-xl shadow-lg w-full max-w-lg p-5">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">Edit Order {{ $order->invoice_number }}</h3>
                                        <button type="button" class="text-gray-400 hover:text-gray-600" @click="openEdit = false">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <form method="POST" action="{{ route('orders-history.update', $order) }}" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Invoice</label>
                                                <input type="text" value="{{ $order->invoice_number }}" disabled class="w-full px-3 py-2 rounded-md border border-gray-200 bg-gray-50 text-sm">
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 mb-1">PO Number</label>
                                                    <input type="text" name="po_number" value="{{ $order->po_number }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Total Amount</label>
                                                    <input type="number" step="0.01" name="total_amount" value="{{ $order->total_amount }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Order</label>
                                                    <input type="date" name="order_date" value="{{ optional($order->order_date)->format('Y-m-d') }}" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Remarks</label>
                                                <textarea name="description" rows="2" class="w-full px-3 py-2 rounded-md border border-gray-200 text-sm focus:ring-[#e05534] focus:border-[#e05534]" placeholder="Catatan tambahan (opsional)">{{ old('description', $order->description) }}</textarea>
                                            </div>
                                        </div>

                                        <div class="flex justify-between items-center pt-2 border-t border-gray-100 mt-2">
                                            <button type="button" class="text-xs font-medium text-gray-500 hover:text-gray-700" @click="openEdit = false">Batal</button>
                                            <button type="submit" class="px-3 py-1.5 rounded-full bg-[#e05534] text-white text-xs font-semibold">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-1 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1.5 items-start text-sm text-gray-700">
                        <div>
                            <h2 class="text-xs font-semibold text-gray-500 tracking-wide">Customer</h2>
                            <p class="font-semibold">{{ $order->user->name }}</p>
                            <p class="text-[11px] text-gray-500">NIK: {{ $order->user->NIK }}</p>
                        </div>
                        <div>
                            <h2 class="text-xs font-semibold text-gray-500 tracking-wide">PO Number</h2>
                            <p class="font-medium">{{ $order->po_number ?: '-' }}</p>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xs font-semibold text-gray-500 tracking-wide">Total Amount</h2>
                            <p class="font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <p class="mt-2 text-[11px] text-gray-500">Remarks: <span class="font-medium">{{ $order->description ?: '--' }}</span></p>
                </div>
                @else
                {{-- Customer view --}}
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <h1 class="text-base sm:text-lg font-semibold text-gray-900">{{ $order->invoice_number }}</h1>
                            <p class="text-[11px] text-gray-400">Tanggal Order: {{ $displayDate->format('d M Y') }}</p>
                            <div class="mt-1 inline-flex items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                                @if($order->status === 'confirmed')
                                <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span>
                                    Mendapatkan Loyalty Points
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xs font-semibold text-gray-500 tracking-wide">Total Amount</h2>
                            <p class="text-sm font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-1 grid grid-cols-1 sm:grid-cols-2 gap-1.5 items-start text-sm text-gray-700">
                        <div>
                            <h2 class="text-xs font-semibold text-gray-500 tracking-wide">Customer</h2>
                            <p class="font-semibold">{{ $order->user->name }}</p>
                            <p class="text-[11px] text-gray-500">NIK: {{ $order->user->NIK }}</p>
                        </div>
                        <div>
                            <h2 class="text-xs font-semibold text-gray-500 tracking-wide">PO Number</h2>
                            <p class="font-medium">{{ $order->po_number ?: '-' }}</p>
                        </div>
                    </div>
                    <p class="mt-2 text-[11px] text-gray-500">Remarks: <span class="font-medium">{{ $order->description ?: '--' }}</span></p>
                </div>
                @endif
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>