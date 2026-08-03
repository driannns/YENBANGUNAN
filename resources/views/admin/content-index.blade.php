<x-admin-layout>
    <x-slot name="header">Kelola Konten</x-slot>

    <div class="max-w-6xl">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div class="flex gap-2">
                    <a href="{{ route('admin.content.index') }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ is_null($type) ? 'bg-[#e05534] text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.content.index', ['type' => 'article']) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ $type === 'article' ? 'bg-[#e05534] text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Blog
                    </a>
                    <a href="{{ route('admin.content.index', ['type' => 'product']) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ $type === 'product' ? 'bg-[#e05534] text-white' : 'bg-white text-gray-600 border border-gray-300' }}">
                        Produk
                    </a>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-900">+ Blog</a>
                    <a href="{{ route('admin.product.create') }}" class="px-4 py-2 bg-[#e05534] text-white text-sm rounded-md hover:bg-[#c74628]">+ Produk</a>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Gambar</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($items as $item)
                        @php
                            $isLegacyUrl = str_contains($item->slug, '/');
                            if ($item->type === 'product' && !$isLegacyUrl) {
                                $viewUrl = route('content.product.show', ['category' => $item->category, 'slug' => $item->slug]);
                            } elseif ($item->type === 'product') {
                                $viewUrl = url('/' . $item->slug);
                            } elseif (!$isLegacyUrl) {
                                $viewUrl = route('content.blog.show', ['slug' => $item->slug]);
                            } else {
                                $parts = explode('/', $item->slug, 4);
                                $viewUrl = preg_match('/^\d{4}$/', $parts[0] ?? '')
                                    ? route('blog.show', ['year' => $parts[0], 'month' => $parts[1] ?? '01', 'day' => $parts[2] ?? '01', 'slug' => $parts[3] ?? $item->slug])
                                    : url('/' . $item->slug);
                            }
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
                            <td class="px-4 py-3 text-gray-500">{{ $item->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ $viewUrl }}" target="_blank" class="text-gray-500 hover:text-gray-800">Lihat</a>
                                    <a href="{{ route('admin.content.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
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
                            <td colspan="6" class="px-4 py-10 text-center text-gray-500">Belum ada konten.</td>
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
