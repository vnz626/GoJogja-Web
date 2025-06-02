<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-custom-blue text-white py-3 rounded-md font-bold hover:bg-blue-600 transition-transform transform hover:scale-105">']) }}>
    {{ $slot }}
</button>

