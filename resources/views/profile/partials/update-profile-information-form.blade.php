<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update akun kamu dengan informasi terbaru.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"  enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- update foto profil --}}
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <img class="w-12 h-12 rounded-full object-cover border-2 border-custom-blue"
                     src="{{ asset('storage/' . $user->profile_photo_path) }}"
                     alt="{{ $user->name }}">
            </div>

            <div>
                <x-input-label for="profile_photo" :value="__('Foto Profil')" />
                <x-text-input id="profile_photo" name="profile_photo" type="file" class="mt-1 block w-full" accept="image/*" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
            </div>
        </div>

        {{-- update nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- update email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- update Jenis kelamin  --}}
        <div class="mb-4">
            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
            <select name="gender" id="gender" class="w-full bg-gray-50 border text-gray-900 p-3 rounded-md
                focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue @error('gender') border-red-500 @enderror">
                <option value="" {{ !old('gender', Auth::user()->gender) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('gender', Auth::user()->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender', Auth::user()->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- update Tanggal lahir --}}
        <div class="mb-6">
            <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" />
            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $user->date_of_birth)" />
            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
        </div>

        {{-- tombol simpan perubahan --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
