<x-admin-layout>
    <x-slot name="header">Edit Halaman Blog</x-slot>

    <div class="max-w-3xl">
        <p class="text-sm text-gray-500 mb-4">
            Ini mengubah teks tetap di halaman listing <strong>/blog</strong> (judul, subjudul, SEO) —
            bukan isi artikel. Untuk artikel, buka menu <a href="{{ route('admin.content.index') }}" class="text-indigo-600 hover:underline">Kelola Konten</a>.
        </p>

        <div class="bg-white p-6 sm:p-8 shadow-sm rounded-lg border border-gray-200">
            <form method="POST" action="{{ route('admin.pages.blog.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

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
                    <a href="{{ route('new-blog') }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900">Lihat Halaman</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
