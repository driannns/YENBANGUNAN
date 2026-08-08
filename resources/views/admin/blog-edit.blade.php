<x-admin-layout>
    <x-slot name="header">Edit Blog</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white p-6 sm:p-8 shadow-sm rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('admin.content.update', $blog->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title" value="Judul" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title', $blog->title)" required autofocus data-slug-source />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi" />
                        <x-quill-editor id="description" name="description" :value="old('description', $currentDescription)" class="block mt-1 w-full" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    @if ($legacyUrl)
                    <div>
                        <x-input-label value="Slug / URL" />
                        <p class="mt-1 text-sm text-gray-500">{{ url('/' . $blog->slug) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Konten lama (hasil import) — URL tidak bisa diubah supaya link yang sudah dibagikan tetap berfungsi.</p>
                    </div>
                    @else
                    <div>
                        <x-input-label for="slug" value="Slug" />
                        <x-text-input id="slug" name="slug" type="text" class="block mt-1 w-full" :value="old('slug', $blog->slug)" data-slug-target />
                        <p class="text-xs text-gray-500 mt-1">URL: {{ url('/') }}/<span data-slug-preview>{{ $blog->slug }}</span></p>
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>
                    @endif

                    <div>
                        <x-input-label for="image" value="Gambar Thumbnail" />
                        <p class="text-xs text-gray-500 mt-1 mb-1">Dipakai sebagai thumbnail di daftar blog.</p>
                        @if ($blog->image_path)
                        <img src="{{ asset('assets' . $blog->image_path) }}" alt="" class="w-24 h-24 object-cover rounded-md border border-gray-200 mt-1 mb-2">
                        @endif
                        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full text-sm">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan kalau tidak ingin mengganti gambar.</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="detail_image" value="Gambar Utama Detail (opsional)" />
                        <p class="text-xs text-gray-500 mt-1 mb-1">Ditampilkan di halaman detail artikel. Kosongkan untuk pakai gambar thumbnail yang sama.</p>
                        @if ($blog->detail_image_path)
                        <img src="{{ asset('assets' . $blog->detail_image_path) }}" alt="" class="w-24 h-24 object-cover rounded-md border border-gray-200 mt-1 mb-2">
                        @endif
                        <input id="detail_image" name="detail_image" type="file" accept="image/png,image/jpeg,image/webp"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full text-sm">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan kalau tidak ingin mengganti gambar.</p>
                        <x-input-error :messages="$errors->get('detail_image')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                        <a href="{{ route('admin.content.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
        </div>
    </div>

    @unless ($legacyUrl)
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
                if (preview) preview.textContent = slugInput.value || 'slug-artikel';
            }

            // Beda dari form create: slug sudah terisi (edit), jadi anggap "touched"
            // dari awal supaya tidak otomatis tertimpa saat judul diketik ulang.
            var slugTouched = true;
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
    @endunless
</x-admin-layout>
