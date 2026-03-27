<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center w-full items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:from-orange-600 hover:to-orange-700 focus:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5 shadow-md hover:shadow-lg ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
