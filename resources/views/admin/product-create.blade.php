<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:p-8 shadow-sm rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" value="Nama Produk" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title')" required autofocus data-slug-source />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category" value="Kategori" />
                        <select id="category" name="category" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">— Pilih kategori —</option>
                            @foreach ($categories as $slug => $label)
                            <option value="{{ $slug }}" @selected(old('category') === $slug)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi Produk" />
                        <textarea id="description" name="description" rows="8" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Pisahkan paragraf dengan baris kosong.</p>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="slug" value="Slug (opsional)" />
                        <x-text-input id="slug" name="slug" type="text" class="block mt-1 w-full" :value="old('slug')" data-slug-target placeholder="otomatis dari nama produk jika dikosongkan" />
                        <p class="text-xs text-gray-500 mt-1">URL: {{ url('/') }}/kategori/<span data-slug-preview>slug-produk</span></p>
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Gambar Produk" />
                        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full text-sm">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Publikasikan') }}</x-primary-button>
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var titleInput = document.querySelector('[data-slug-source]');
            var slugInput = document.querySelector('[data-slug-target]');
            var preview = document.querySelector('[data-slug-preview]');
            if (!titleInput || !slugInput) return;

            function slugify(value) {
                return value.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            }

            function updatePreview() {
                if (preview) preview.textContent = slugInput.value || 'slug-produk';
            }

            var slugTouched = slugInput.value.length > 0;
            slugInput.addEventListener('input', function () {
                slugTouched = true;
                updatePreview();
            });
            titleInput.addEventListener('input', function () {
                if (!slugTouched) {
                    slugInput.value = slugify(titleInput.value);
                    updatePreview();
                }
            });
            updatePreview();
        })();
    </script>
</x-app-layout>
