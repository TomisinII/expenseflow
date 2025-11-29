<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-3 bg-white text-indigo-600 hover:bg-gray-100 border border-indigo-600 rounded-md font-semibold text-xs tracking-widest shadow-sm hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
