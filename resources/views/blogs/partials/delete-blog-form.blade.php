<section class="space-y-3">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hapus Blog') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah dihapus, blog ini tidak dapat dipulihkan. Pastikan Anda telah menyimpan informasi penting sebelum menghapus.') }}
        </p>
    </header>

    <x-danger-button
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion')"
    >
        {{ __('Hapus Blog') }}
    </x-danger-button>

    <x-modal name="confirm-blog-deletion" :show="false" focusable>
        <form method="POST" action="{{ route('blogs.destroy', $blog->id) }}" class="p-3">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Apakah Anda yakin ingin menghapus blog ini?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah blog ini dihapus, semua konten terkait akan hilang secara permanen.') }}
            </p>

            {{-- Jika ingin menambahkan password konfirmasi, aktifkan bagian ini
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            --}}

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Blog') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
