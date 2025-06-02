@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-gray-50 border border-gray-300 text-gray-900 p-3 rounded-md
    focus:outline-none focus:ring-2 focus:ring-custom-blue focus:border-custom-blue ']) }}>

