<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($header) ? $header . ' - ' : '' }}Admin - Yen Bangunan</title>
    <link rel="icon" href="{{ asset('assets/logo-crop.png') }}">

    {{-- Tailwind, Alpine.js, dan Quill dimuat lewat CDN (bukan hasil build Vite) —
         supaya panel admin tidak bergantung pada folder public/build/ ter-upload
         benar di server. Semua class Tailwind di file admin/* tetap berfungsi
         apa adanya karena Tailwind CDN meng-compile class saat runtime di browser. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
    <!-- Quill Table Module -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill-table-module@latest/dist/quill-table-module.css">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-table-module@latest/dist/quill-table-module.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        /* Quill Wrapper */
        .quill-wrapper {
            display: flex;
            flex-direction: column;
            border-radius: 0.375rem;
            overflow: hidden;
            border: 1px solid #d1d5db;
        }

        .quill-wrapper:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 1px #6366f1;
        }

        .quill-toolbar.ql-toolbar.ql-snow {
            border: none;
            background: #f9fafb;
            padding: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .quill-toolbar .ql-formats {
            display: flex;
            gap: 0.25rem;
            margin-right: 0.5rem;
            padding-right: 0.5rem;
            border-right: 1px solid #e5e7eb;
        }

        .quill-toolbar .ql-formats:last-child {
            border-right: none;
            margin-right: 0;
            padding-right: 0;
        }

        .ql-container.ql-snow {
            border: none;
            font-size: 0.875rem;
        }

        .ql-editor {
            min-height: 12rem;
            line-height: 1.5rem;
            padding: 1rem;
        }

        .ql-editor.ql-blank::before {
            color: #9ca3af;
            font-style: italic;
        }

        /* Table styling */
        .ql-editor table {
            border-collapse: collapse;
            width: 100%;
            margin: 1rem 0;
        }

        .ql-editor table tr {
            border-bottom: 1px solid #d1d5db;
        }

        .ql-editor table td {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            min-width: 3rem;
        }

        .ql-editor table th {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            background-color: #f3f4f6;
            font-weight: 600;
        }

        .ql-toolbar.ql-snow .ql-table,
        .ql-toolbar.ql-snow .ql-insert-row,
        .ql-toolbar.ql-snow .ql-insert-col,
        .ql-toolbar.ql-snow .ql-delete-row,
        .ql-toolbar.ql-snow .ql-delete-col,
        .ql-toolbar.ql-snow .ql-delete-table {
            width: auto;
            height: 1.875rem;
        }

        /* Table button icons */
        .ql-toolbar.ql-snow .ql-table::before {
            content: '📋';
            font-size: 1rem;
        }

        .ql-toolbar.ql-snow .ql-insert-row::before {
            content: '➕ Row';
            font-size: 0.75rem;
        }

        .ql-toolbar.ql-snow .ql-insert-col::before {
            content: '➕ Col';
            font-size: 0.75rem;
        }

        .ql-toolbar.ql-snow .ql-delete-row::before {
            content: '❌ Row';
            font-size: 0.75rem;
        }

        .ql-toolbar.ql-snow .ql-delete-col::before {
            content: '❌ Col';
            font-size: 0.75rem;
        }

        .ql-toolbar.ql-snow .ql-delete-table::before {
            content: '❌ Tbl';
            font-size: 0.75rem;
        }

        /* Form Fields Stroke */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="url"],
        input[type="date"],
        input[type="time"],
        input[type="datetime-local"],
        input[type="tel"],
        input[type="search"],
        textarea,
        select {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="url"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus,
        input[type="datetime-local"]:focus,
        input[type="tel"]:focus,
        input[type="search"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 1px #6366f1;
        }

        input[type="file"] {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        input[type="file"]:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 1px #6366f1;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Overlay (mobile) -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

        <!-- Sidebar: selalu fixed & 100% tinggi viewport, tidak ikut scroll bersama konten -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 h-screen w-64 bg-gray-900 text-gray-300 flex flex-col transition-transform duration-200 ease-in-out lg:translate-x-0">
            <div class="h-16 flex items-center gap-2 px-5 border-b border-gray-800">
                <img src="{{ asset('assets/logo.png') }}" alt="Yen Bangunan" class="h-6 w-auto">
                <span class="text-xs uppercase tracking-wider text-gray-500">Admin</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-[#e05534] text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75 12 3l9 6.75V21a.75.75 0 0 1-.75.75H3.75A.75.75 0 0 1 3 21V9.75Z"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.content.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.content.*') ? 'bg-[#e05534] text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
                    Kelola Konten
                </a>

                <div class="pt-4 mt-4 border-t border-gray-800">
                    <p class="px-3 mb-1 text-xs uppercase tracking-wider text-gray-600">Buat Baru</p>

                    <a href="{{ route('admin.blog.create') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.blog.create') ? 'bg-[#e05534] text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                        Blog
                    </a>

                    <a href="{{ route('admin.product.create') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.product.create') ? 'bg-[#e05534] text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5-12 3 3.75 7.5m16.5 0L12 12m8.25-4.5v9L12 21m0-9L3.75 7.5m8.25 4.5v9M3.75 7.5v9L12 21"/></svg>
                        Produk
                    </a>
                </div>

                <div class="pt-4 mt-4 border-t border-gray-800">
                    <p class="px-3 mb-1 text-xs uppercase tracking-wider text-gray-600">Edit Halaman</p>

                    <a href="{{ route('admin.pages.blog.edit') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.pages.blog.edit') ? 'bg-[#e05534] text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                        Halaman Blog
                    </a>

                    <a href="{{ route('admin.pages.product.edit') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.pages.product.edit') ? 'bg-[#e05534] text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                        Halaman Produk
                    </a>
                </div>
            </nav>

            <div class="p-3 border-t border-gray-800 space-y-1">
                <a href="{{ route('home') }}" target="_blank"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Lihat Situs
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15"/></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main: diberi margin kiri selebar sidebar (lg+) supaya tidak tertutup sidebar yang fixed -->
        <div class="flex flex-col min-w-0 lg:ml-64">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
                    </button>
                    <h1 class="font-semibold text-lg text-gray-800">{{ $header ?? 'Admin' }}</h1>
                </div>
                <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">
                    {{ session('status') }}
                </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

</body>

</html>
