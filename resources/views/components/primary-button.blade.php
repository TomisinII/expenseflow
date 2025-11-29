<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-1 px-4 py-3 bg-gradient-to-br from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
