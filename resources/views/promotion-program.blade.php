<x-app-layout>
    <a href="https://wa.link/3v66z0" 
        target="_blank"
        class="fixed whatsapp-pulse whatsapp-bounce bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg hover:scale-110 transition-all duration-300 z-50" aria-label="WhatsApp">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </a>
        <style>
            /* Bouncing animation for WhatsApp floating button */
            .whatsapp-bounce {
                animation: whatsappBounce 2s cubic-bezier(.28,.84,.42,1) infinite;
                transform-origin: center;
            }
            @keyframes whatsappBounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-20px); }
                60% { transform: translateY(-1px); }
            }
        </style>
        <div class="w-full bg-[#C0392B] text-white py-3 overflow-hidden shadow-lg fixed top-0 left-0 z-50">
            <div class="flex items-center">
                <!-- Label with Countdown -->
                <div class="flex items-center gap-1 bg-white text-red-600 px-4 py-2 font-bold text-sm flex-shrink-0">
                    <div class="uppercase">Promo</div>
                    <div id="countdown" class="text-xs font-normal">00D 00H 00M 00S</div>
                </div>
                
                <!-- Scrolling Text Container -->
                <div class="flex-1 overflow-hidden relative ml-4">
                    <div id="runningText" class="whitespace-nowrap inline-block" style="position: relative;"></div>
                </div>
            </div>
            <!-- Confirmation Modal -->
        </div>
        <div class="w-full z-40 top-0 start-0" style="margin-top: 3.7rem">
            <nav x-data="{ open: false }" class="bg-black text-white">
                <!-- Primary Navigation Menu -->
                 <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex justify-between">
                            <!-- Logo -->
                            <div class="shrink-0 w-2/12 md:w-1/2 lg:w-3/12 flex items-center">
                                <a href="{{ route('dashboard') }}" class="w-4/12">
                                    <x-application-logo class="block w-10 fill-current text-gray-800" />
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="w-1/2 items-center justify-center hidden space-x-8 sm:-my-px sm:ms-10 sm:flex font-d-din uppercase">
                                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" style="margin-right: 0 !important;">
                                    {{ __('Home') }}
                                </x-nav-link>
                                <x-nav-link :href="route('product')" :active="request()->routeIs('product')">
                                    {{ __('Product') }}
                                </x-nav-link>
                                <x-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')">
                                    {{ __('About Us') }}
                                </x-nav-link>
                                <x-nav-link :href="route('blog')" :active="request()->routeIs('blog')">
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

            <!-- Redeem Points Section (merged from redeem-points.blade.php) -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h2 class="text-2xl font-bold text-gray-900">Redeem Points</h2>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Your Current Points</p>
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($loyaltyPoints ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Promotion Program Section -->
            <div class="container mx-auto px-4 py-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-extrabold">Produk yang Bisa Ditukar dengan Loyalty Points</h1>
                    @if(auth()->user()->is_manager)
                    <button
                        type="button"
                        onclick="openModal('createRedeemItemModal','createRedeemItemContent')"
                        class="bg-[#e05534] text-white px-4 py-2 rounded-full text-xs font-bold">
                        Create
                    </button>
                    @endif
                </div>

                @if(isset($redeemItems) && $redeemItems->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($redeemItems as $item)
                    @php
                        $modalId = 'modal-' . $item->id;
                        $contentId = 'modalContent-' . $item->id;
                        $qtyId = 'qty-' . $item->id;
                        $totalPointId = 'totalPoint-' . $item->id;
                        $editModalId = 'editRedeemItemModal-' . $item->id;
                        $editContentId = 'editRedeemItemContent-' . $item->id;
                        $deleteModalId = 'deleteRedeemItemModal-' . $item->id;
                        $deleteContentId = 'deleteRedeemItemContent-' . $item->id;
                    @endphp

                    <div class="bg-white border rounded-lg shadow-sm p-4 flex flex-col relative">
                        <div class="h-40 bg-gray-100 rounded-md mb-4 flex items-center justify-center">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="max-h-36 object-contain"/>
                            @else
                                <div class="text-gray-500 text-sm">Redeem Item</div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h2 class="font-semibold text-lg">{{ $item->name }}</h2>
                            <p class="text-sm text-gray-500 mt-2">
                                {{ $item->description ?? 'Tukarkan poin sekarang.' }}
                            </p>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-sm text-gray-700 font-bold">
                                {{ number_format($item->points_required) }} Points
                            </div>

                            <div class="flex items-center gap-2">
                                @if(auth()->user()->is_manager)
                                <button type="button" onclick="openModal('{{ $editModalId }}','{{ $editContentId }}')" class="text-blue-600 hover:text-blue-800" aria-label="Edit">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                </button>
                                <button type="button" onclick="openModal('{{ $deleteModalId }}','{{ $deleteContentId }}')" class="text-red-600 hover:text-red-800" aria-label="Delete">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4h8v2m-1 0v14a2 2 0 01-2 2H9a2 2 0 01-2-2V6h10z"/>
                                    </svg>
                                </button>
                                @endif
                                <button
                                    type="button"
                                    onclick="openModal('{{ $modalId }}','{{ $contentId }}')"
                                    class="bg-[#e05534] text-white px-4 py-2 rounded-full text-xs font-bold">
                                    Tukar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL -->
                    <div id="{{ $modalId }}"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">

                        <form action="{{ route('loyalty.redeem.process') }}" method="post" id="{{ $contentId }}"
                            class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl
                                transform scale-95 opacity-0 transition-all duration-300">
                            @csrf

                            <!-- Header -->
                            <div class="flex justify-between items-center px-6 py-4 border-b">
                                <h2 class="font-semibold text-lg">
                                    Redeem {{ $item->name }}
                                </h2>
                                <button onclick="closeModal('{{ $modalId }}','{{ $contentId }}')">✕</button>
                            </div>

                            <!-- Body -->
                            <div class="px-6 py-4 space-y-4">
                                <input type="hidden" name="redeem_item_id" value="{{ $item->id }}">
                                <div class="flex justify-center">
                                    @if($item->image_url)
                                        <img src="{{ $item->image_url }}" class="h-32 object-contain rounded-md bg-gray-100 p-2">
                                    @else
                                        <div class="h-32 w-full rounded-md bg-gray-100 flex items-center justify-center text-gray-500 text-sm">No Image</div>
                                    @endif
                                </div>
                                <!-- Qty -->
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Jumlah (Qty)</label>
                                    <input
                                        id="{{ $qtyId }}"
                                        name="quantity"
                                        type="number"
                                        min="1"
                                        value="1"
                                        oninput="calculatePoint({{ $item->points_required }}, '{{ $qtyId }}', '{{ $totalPointId }}')"
                                        class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-orange-200">
                                </div>

                                <!-- Total Point -->
                                <div class="bg-gray-50 rounded-lg p-3 flex justify-between text-sm">
                                    <span>Total Point</span>
                                    <span class="font-bold text-orange-600">
                                        <span id="{{ $totalPointId }}">
                                            {{ number_format($item->points_required) }}
                                        </span> Points
                                    </span>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                                <button
                                    onclick="closeModal('{{ $modalId }}','{{ $contentId }}')"
                                    class="px-4 py-2 border rounded-lg">
                                    Batal
                                </button>
                                <button
                                    class="px-4 py-2 bg-[#e05534] text-white rounded-lg">
                                    Redeem
                                </button>
                            </div>
                        </form>
                    </div>

                    @if(auth()->user()->is_manager)
                    <!-- EDIT MODAL -->
                    <div id="{{ $editModalId }}"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
                        <form method="POST" action="{{ route('redeem-items.update', $item) }}" id="{{ $editContentId }}" enctype="multipart/form-data"
                            class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl transform scale-95 opacity-0 transition-all duration-300">
                            @csrf
                            @method('PUT')
                            <div class="flex justify-between items-center px-6 py-4 border-b">
                                <h2 class="font-semibold text-lg">Edit Redeem Item</h2>
                                <button type="button" onclick="closeModal('{{ $editModalId }}','{{ $editContentId }}')">✕</button>
                            </div>
                            <div class="px-6 py-4 space-y-4">
                                <div class="flex justify-center">
                                    <img id="editImagePreview-{{ $item->id }}" src="{{ $item->image_url ?? '' }}" class="h-32 object-contain rounded-md bg-gray-100 p-2 {{ $item->image_url ? '' : 'hidden' }}">
                                    <div id="editImagePlaceholder-{{ $item->id }}" class="h-32 w-full rounded-md bg-gray-100 flex items-center justify-center text-gray-500 text-sm {{ $item->image_url ? 'hidden' : '' }}">No Image</div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 text-sm text-gray-700">
                                        <input type="radio" name="image_source" value="keep" checked
                                               onchange="setImageSource('edit-{{ $item->id }}','keep','{{ $editContentId }}')">
                                        Keep
                                    </label>
                                    <label class="flex items-center gap-2 text-sm text-gray-700">
                                        <input type="radio" name="image_source" value="url"
                                               onchange="setImageSource('edit-{{ $item->id }}','url','{{ $editContentId }}')">
                                        URL
                                    </label>
                                    <label class="flex items-center gap-2 text-sm text-gray-700">
                                        <input type="radio" name="image_source" value="file"
                                               onchange="setImageSource('edit-{{ $item->id }}','file','{{ $editContentId }}')">
                                        File
                                    </label>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" value="{{ $item->name }}" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                                </div>
                                <div id="edit-{{ $item->id }}-url" class="hidden">
                                    <label class="text-sm font-medium text-gray-700">Image URL</label>
                                    <input type="text" name="image_url" value="{{ $item->image_url }}" class="w-full mt-1 border rounded-lg px-3 py-2"
                                           oninput="setImageSource('edit-{{ $item->id }}','url','{{ $editContentId }}'); updateImagePreviewUrl(this.value,'editImagePreview-{{ $item->id }}','editImagePlaceholder-{{ $item->id }}')">
                                </div>
                                <div id="edit-{{ $item->id }}-file" class="hidden">
                                    <label class="text-sm font-medium text-gray-700">Image File</label>
                                    <input type="file" name="image_file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="w-full mt-1 border rounded-lg px-3 py-2"
                                           onchange="setImageSource('edit-{{ $item->id }}','file','{{ $editContentId }}'); updateImagePreviewFile(this,'editImagePreview-{{ $item->id }}','editImagePlaceholder-{{ $item->id }}')">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="description" value="{{ $item->description }}" class="w-full mt-1 border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Points Required</label>
                                    <input type="number" name="points_required" min="1" value="{{ $item->points_required }}" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Unit</label>
                                    <input type="text" name="unit" value="{{ $item->unit }}" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="rounded" {{ $item->is_active ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600">Active</span>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                                <button type="button" onclick="closeModal('{{ $editModalId }}','{{ $editContentId }}')" class="px-4 py-2 border rounded-lg">Batal</button>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Save</button>
                            </div>
                        </form>
                    </div>

                    <!-- DELETE MODAL -->
                    <div id="{{ $deleteModalId }}"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
                        <form method="POST" action="{{ route('redeem-items.destroy', $item) }}" id="{{ $deleteContentId }}"
                            class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl transform scale-95 opacity-0 transition-all duration-300">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-between items-center px-6 py-4 border-b">
                                <h2 class="font-semibold text-lg text-red-600">Delete Redeem Item</h2>
                                <button type="button" onclick="closeModal('{{ $deleteModalId }}','{{ $deleteContentId }}')">✕</button>
                            </div>
                            <div class="px-6 py-4 space-y-2">
                                <p>Yakin mau delete item ini?</p>
                                <p class="text-sm text-gray-600">{{ $item->name }}</p>
                            </div>
                            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                                <button type="button" onclick="closeModal('{{ $deleteModalId }}','{{ $deleteContentId }}')" class="px-4 py-2 border rounded-lg">Batal</button>
                                <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Delete</button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endforeach
                </div>
                @else
                    <p class="text-gray-500">No redeem items available.</p>
                @endif
            </div>
            <!-- Hidden cancel form (will be submitted by modal confirm) -->
            <form id="cancelForm" method="POST" style="display:none;">
                @csrf
            </form>
            <!-- User Redeem Requests -->
            <div class="container mx-auto px-4 py-6">
                <h3 class="text-xl font-semibold mb-4">Your Redeem Requests</h3>
                @if(isset($userRedeems) && $userRedeems->isNotEmpty())
                <div class="grid grid-cols-1 gap-4">
                    @foreach($userRedeems as $r)
                        <div class="p-4 border rounded-md bg-white flex items-center justify-between">
                            <div>
                                <div class="font-medium">
                                    {{ $r->redeemItem->name ?? 'Item' }} &times; {{ $r->quantity }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    Points: {{ number_format($r->points_used, 0, ',', '.') }}
                                    — Submitted: {{ $r->created_at->format('d M Y H:i') }}
                                </div>
                                <div class="text-sm mt-1">
                                    Status:
                                    @php
                                        $status = strtolower($r->status);
                                        $badgeClass = match ($status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'redeemed' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'cancelled' => 'bg-gray-100 text-gray-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-sm font-semibold {{ $badgeClass }}">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($r->status === 'pending')
                                    <button
                                        type="button"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md open-cancel-modal"
                                        data-action="{{ route('loyalty.redeem.cancel', $r->id) }}">
                                        Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $userRedeems->links('vendor.pagination.light') }}
                </div>
            @else
                <p class="text-gray-500">You have no redeem requests.</p>
            @endif

            </div>

            @if(auth()->user()->is_manager)
            <!-- CREATE MODAL -->
            <div id="createRedeemItemModal"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
                <form method="POST" action="{{ route('redeem-items.store') }}" id="createRedeemItemContent" enctype="multipart/form-data"
                    class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl transform scale-95 opacity-0 transition-all duration-300">
                    @csrf
                    <div class="flex justify-between items-center px-6 py-4 border-b">
                        <h2 class="font-semibold text-lg">Create Redeem Item</h2>
                        <button type="button" onclick="closeModal('createRedeemItemModal','createRedeemItemContent')">✕</button>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="flex justify-center">
                            <img id="createImagePreview" src="" class="h-32 object-contain rounded-md bg-gray-100 p-2 hidden">
                            <div id="createImagePlaceholder" class="h-32 w-full rounded-md bg-gray-100 flex items-center justify-center text-gray-500 text-sm">No Image</div>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="radio" name="image_source" value="url" checked
                                       onchange="setImageSource('create','url','createRedeemItemContent')">
                                URL
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="radio" name="image_source" value="file"
                                       onchange="setImageSource('create','file','createRedeemItemContent')">
                                File
                            </label>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                        </div>
                        <div id="create-url">
                            <label class="text-sm font-medium text-gray-700">Image URL</label>
                            <input type="text" name="image_url" class="w-full mt-1 border rounded-lg px-3 py-2"
                                   oninput="setImageSource('create','url','createRedeemItemContent'); updateImagePreviewUrl(this.value,'createImagePreview','createImagePlaceholder')">
                        </div>
                        <div id="create-file" class="hidden">
                            <label class="text-sm font-medium text-gray-700">Image File</label>
                            <input type="file" name="image_file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="w-full mt-1 border rounded-lg px-3 py-2"
                                   onchange="setImageSource('create','file','createRedeemItemContent'); updateImagePreviewFile(this,'createImagePreview','createImagePlaceholder')">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Description</label>
                            <input type="text" name="description" class="w-full mt-1 border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Points Required</label>
                            <input type="number" name="points_required" min="1" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" name="unit" value="pcs" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" class="rounded" checked>
                            <span class="text-sm text-gray-600">Active</span>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 px-6 py-4 border-t">
                        <button type="button" onclick="closeModal('createRedeemItemModal','createRedeemItemContent')" class="px-4 py-2 border rounded-lg">Batal</button>
                        <button class="px-4 py-2 bg-[#e05534] text-white rounded-lg">Create</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
            <script>
                function openModal(modalId, contentId) {
                    const modal = document.getElementById(modalId);
                    const content = document.getElementById(contentId);

                    if (!modal || !content) return;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    setTimeout(() => {
                        content.classList.remove('scale-95','opacity-0');
                        content.classList.add('scale-100','opacity-100');
                    }, 10);
                }

                function closeModal(modalId, contentId) {
                    const modal = document.getElementById(modalId);
                    const content = document.getElementById(contentId);

                    if (!modal || !content) return;
                    content.classList.add('scale-95','opacity-0');

                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }, 300);
                }

                function calculatePoint(pointPerItem, qtyId, totalPointId) {
                    const qty = document.getElementById(qtyId).value || 0;
                    const total = qty * pointPerItem;

                    document.getElementById(totalPointId).innerText =
                        new Intl.NumberFormat('id-ID').format(total);
                }

                function updateImagePreviewUrl(url, imgId, placeholderId) {
                    const img = document.getElementById(imgId);
                    const placeholder = document.getElementById(placeholderId);
                    if (!img || !placeholder) return;
                    if (!url) {
                        img.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                        img.removeAttribute('src');
                        return;
                    }
                    img.src = url;
                    img.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }

                function updateImagePreviewFile(input, imgId, placeholderId) {
                    const img = document.getElementById(imgId);
                    const placeholder = document.getElementById(placeholderId);
                    if (!img || !placeholder) return;
                    const file = input.files && input.files[0];
                    if (!file) {
                        img.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                        img.removeAttribute('src');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }

                function toggleImageSource(prefix, source) {
                    const urlWrap = document.getElementById(prefix + '-url');
                    const fileWrap = document.getElementById(prefix + '-file');
                    if (urlWrap) urlWrap.classList.toggle('hidden', source !== 'url');
                    if (fileWrap) fileWrap.classList.toggle('hidden', source !== 'file');
                }

                function setImageSource(prefix, source, formId) {
                    const form = document.getElementById(formId);
                    if (form) {
                        const radio = form.querySelector(`input[name="image_source"][value="${source}"]`);
                        if (radio) radio.checked = true;
                        if (source === 'url') {
                            const fileInput = form.querySelector('input[name="image_file"]');
                            if (fileInput) fileInput.value = '';
                        }
                        if (source === 'file') {
                            const urlInput = form.querySelector('input[name="image_url"]');
                            if (urlInput) urlInput.value = '';
                        }
                    }
                    toggleImageSource(prefix, source);
                }
            </script>
            <script>
                // Update total points when quantity changes (if redeemItems present)
                document.addEventListener('DOMContentLoaded', function() {
                    @if(isset($redeemItems))
                        @foreach($redeemItems as $item)
                        const quantityInput{{ $item->id }} = document.getElementById('quantity_{{ $item->id }}');
                        const totalPoints{{ $item->id }} = document.getElementById('total_points_{{ $item->id }}');

                        if (quantityInput{{ $item->id }}) {
                            quantityInput{{ $item->id }}.addEventListener('input', function() {
                                const quantity = parseInt(this.value) || 1;
                                const pointsPerUnit = {{ $item->points_required }};
                                const total = quantity * pointsPerUnit;
                                totalPoints{{ $item->id }}.textContent = total.toLocaleString();
                            });
                        }
                        @endforeach
                    @endif
                });

                // Cancel confirmation modal
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = document.getElementById('confirmModal');
                    const openBtns = document.querySelectorAll('.open-cancel-modal');
                    const closeBtn = document.getElementById('closeCancelModalBtn');
                    const confirmBtn = document.getElementById('confirmCancelBtn');
                    const cancelForm = document.getElementById('cancelForm');

                    let currentAction = null;

                    openBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            currentAction = this.dataset.action;
                            if (modal) modal.classList.remove('hidden');
                            if (modal) modal.classList.add('flex');
                        });
                    });

                    function closeModal() {
                        if (modal) modal.classList.add('hidden');
                        if (modal) modal.classList.remove('flex');
                        currentAction = null;
                    }

                    if (closeBtn) closeBtn.addEventListener('click', closeModal);

                    if (confirmBtn) confirmBtn.addEventListener('click', function() {
                        if (!currentAction) return closeModal();
                        // set action and submit hidden form
                        cancelForm.action = currentAction;
                        cancelForm.submit();
                    });
                });
            </script>
        </div>
</x-app-layout>
