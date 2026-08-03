<x-admin-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Total Blog</p>
            <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $articleCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $productCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <a href="{{ route('admin.blog.create') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:border-[#e05534] hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-gray-900">Buat Blog Baru</h3>
            <p class="mt-2 text-sm text-gray-600">Tulis artikel baru untuk halaman Blog.</p>
        </a>

        <a href="{{ route('admin.product.create') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:border-[#e05534] hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-gray-900">Buat Produk Baru</h3>
            <p class="mt-2 text-sm text-gray-600">Tambah produk baru lengkap dengan kategori.</p>
        </a>

        <a href="{{ route('admin.content.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:border-[#e05534] hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-gray-900">Kelola Konten</h3>
            <p class="mt-2 text-sm text-gray-600">Lihat, edit, atau hapus blog & produk yang sudah ada.</p>
        </a>
    </div>
</x-admin-layout>
