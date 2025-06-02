
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoJogja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
            extend: {
                fontFamily: {
                sans: ['Poppins', 'sans-serif'],
                },
                colors: {
                'custom-blue': '#518EF8',
                'overlay-blue': '#6DC3F5', // Warna ini akan kita gunakan
                }
            }
            }
        }
    </script>
    <style>
        body {
            background-image: url('/images/auth-background.jpg');
        }
    </style>
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center font-sans">
    <div class="absolute inset-0 bg-overlay-blue opacity-50"></div>

    <div class="relative z-10 w-full max-w-md bg-white bg-opacity-85 p-8 rounded-lg shadow-xl text-gray-800">
        <div class="text-center mb-8">
            <a href="/">
                <img src="/images/logo.png" alt="GoJogja Logo" class="h-16 mx-auto mb-4">
            </a>
            <h1 class="text-xl font-bold text-gray-800">Lupa Kata Sandi?</h1>
            <p class="text-gray-600">Tenang, kirimkan saja email kamu</p>
        </div>

                <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form action="/login" method="POST">

            @csrf
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</body>
</html>


        {{-- <x-guest-layout>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout> --}}
