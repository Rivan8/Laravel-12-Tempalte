@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm text-gray-700 bg-gray-50 focus:bg-white transition-all duration-300 ease-in-out w-full px-4 py-3']) }}>
