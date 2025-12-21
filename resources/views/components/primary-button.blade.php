<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-1 px-4 py-3 bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-700 dark:to-purple-700 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150 whitespace-nowrap']) }}>
    {{ $slot }}
</button>
