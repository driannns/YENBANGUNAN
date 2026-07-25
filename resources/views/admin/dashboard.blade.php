<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">
                {{ session('status') }}
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="{{ route('admin.blog.create') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:border-[#e05534] hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-900">Buat Blog Baru</h3>
                    <p class="mt-2 text-sm text-gray-600">Tulis artikel baru untuk halaman Blog.</p>
                </a>

                <a href="{{ route('admin.product.create') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:border-[#e05534] hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-900">Buat Produk Baru</h3>
                    <p class="mt-2 text-sm text-gray-600">Tambah produk baru lengkap dengan kategori.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
