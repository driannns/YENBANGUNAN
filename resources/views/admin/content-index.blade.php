<x-admin-layout>
    <x-slot name="header">Kelola Konten</x-slot>

    <div class="max-w-6xl">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.content.index', ['search' => $search ?: null, 'status' => $status]) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ is_null($type) ? 'bg-[#e05534] text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.content.index', ['type' => 'article', 'search' => $search ?: null, 'status' => $status]) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ $type === 'article' ? 'bg-[#e05534] text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Blog
                    </a>
                    <a href="{{ route('admin.content.index', ['type' => 'product', 'search' => $search ?: null, 'status' => $status]) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ $type === 'product' ? 'bg-[#e05534] text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Produk
                    </a>

                    <span class="hidden sm:block w-px self-stretch bg-gray-300 mx-1"></span>

                    <a href="{{ route('admin.content.index', ['type' => $type, 'search' => $search ?: null]) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ is_null($status) ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('admin.content.index', ['type' => $type, 'search' => $search ?: null, 'status' => 'active']) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ $status === 'active' ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Aktif
                    </a>
                    <a href="{{ route('admin.content.index', ['type' => $type, 'search' => $search ?: null, 'status' => 'archived']) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ $status === 'archived' ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Diarsipkan
                    </a>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-900">+ Blog</a>
                    <a href="{{ route('admin.product.create') }}" class="px-4 py-2 bg-[#e05534] text-white text-sm rounded-md hover:bg-[#c74628]">+ Produk</a>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.content.index') }}" class="mb-4">
                @if ($type)
                    <input type="hidden" name="type" value="{{ $type }}">
                @endif
                @if ($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul blog atau produk..."
                        class="w-full sm:max-w-md px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-[#e05534] focus:border-[#e05534]">
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-900">Cari</button>
                        @if ($search)
                            <a href="{{ route('admin.content.index', ['type' => $type, 'status' => $status]) }}" class="px-4 py-2 bg-white text-gray-600 border border-gray-300 text-sm rounded-md hover:bg-gray-50">Reset</a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-x-auto">
                <table class="w-full min-w-[720px] text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Gambar</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($items as $item)
                        @php
                            $viewUrl = $item->publicUrl();
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                @if ($item->image_path)
                                <img src="{{ asset('assets' . $item->image_path) }}" alt="" class="w-12 h-12 object-cover rounded-md border border-gray-200">
                                @else
                                <div class="w-12 h-12 rounded-md bg-gray-100"></div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900 max-w-xs truncate">{{ html_entity_decode($item->title) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs {{ $item->type === 'product' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $item->type === 'product' ? 'Produk' : 'Blog' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->category ? config('product_categories')[$item->category] ?? $item->category : '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs {{ $item->status === 'archived' ? 'bg-gray-100 text-gray-500' : 'bg-green-100 text-green-700' }}">
                                    {{ $item->status === 'archived' ? 'Diarsipkan' : 'Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ $viewUrl }}" target="_blank" class="text-gray-500 hover:text-gray-800">Lihat</a>
                                    <a href="{{ route('admin.content.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form method="POST" action="{{ route('admin.content.toggle-status', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="text-amber-600 hover:text-amber-800">
                                            {{ $item->status === 'archived' ? 'Aktifkan' : 'Arsipkan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.content.destroy', $item->id) }}"
                                        onsubmit="return confirm('Hapus &quot;{{ addslashes($item->title) }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                {{ $search ? 'Tidak ada konten yang cocok dengan "' . $search . '".' : 'Belum ada konten.' }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
    </div>
</x-admin-layout>
