<x-admin-layout>
    <x-slot name="header">Edit Halaman Produk</x-slot>

    <div class="max-w-3xl">
        <p class="text-sm text-gray-500 mb-4">
            Ini mengubah teks tetap di halaman listing <strong>/product</strong> (judul, subjudul, copy tiap
            kategori, SEO) — bukan isi produk satu-satu. Untuk produk, buka menu <a href="{{ route('admin.content.index') }}" class="text-indigo-600 hover:underline">Kelola Konten</a>.
        </p>

        <div class="bg-white p-6 sm:p-8 shadow-sm rounded-lg border border-gray-200">
            <form method="POST" action="{{ route('admin.pages.product.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <p class="text-xs uppercase tracking-wider text-gray-500">Judul & Subjudul saat "Semua Produk" (tanpa kategori dipilih)</p>

                <div>
                    <x-input-label for="heading" value="Judul Halaman (H1)" />
                    <x-text-input id="heading" name="heading" type="text" class="block mt-1 w-full" :value="old('heading', $page['heading'])" required />
                    <x-input-error :messages="$errors->get('heading')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="subtitle" value="Subjudul" />
                    <textarea id="subtitle" name="subtitle" rows="3" required
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('subtitle', $page['subtitle']) }}</textarea>
                    <x-input-error :messages="$errors->get('subtitle')" class="mt-2" />
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">Judul & Copy per Kategori</p>

                    <div class="space-y-2">
                        @foreach ($page['categories'] as $slug => $category)
                        @php
                            $labelKey = "categories.$slug.label";
                            $copyKey = "categories.$slug.copy";
                        @endphp
                        <details class="border border-gray-200 rounded-md">
                            <summary class="px-4 py-2.5 cursor-pointer text-sm font-medium text-gray-700 select-none">
                                {{ old($labelKey, $category['label']) }}
                            </summary>
                            <div class="p-4 pt-0 space-y-3">
                                <div>
                                    <x-input-label for="cat-{{ $slug }}-label" value="Judul Kategori" />
                                    <x-text-input id="cat-{{ $slug }}-label" name="categories[{{ $slug }}][label]" type="text" class="block mt-1 w-full" :value="old($labelKey, $category['label'])" required />
                                    <x-input-error :messages="$errors->get($labelKey)" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="cat-{{ $slug }}-copy" value="Copy Kategori" />
                                    <textarea id="cat-{{ $slug }}-copy" name="categories[{{ $slug }}][copy]" rows="3" required
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old($copyKey, $category['copy']) }}</textarea>
                                    <x-input-error :messages="$errors->get($copyKey)" class="mt-2" />
                                </div>
                            </div>
                        </details>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">SEO</p>

                    <div>
                        <x-input-label for="meta_title" value="Judul Tab Browser" />
                        <x-text-input id="meta_title" name="meta_title" type="text" class="block mt-1 w-full" :value="old('meta_title', $page['meta_title'])" required />
                        <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="meta_description" value="Meta Description" />
                        <textarea id="meta_description" name="meta_description" rows="2" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('meta_description', $page['meta_description']) }}</textarea>
                        <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                    <a href="{{ route('new-product') }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900">Lihat Halaman</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
