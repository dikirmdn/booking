<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex items-center justify-center px-6 py-3 bg-red-500 hover:bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 focus:from-blue-700 focus:to-indigo-700 active:from-blue-800 active:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
