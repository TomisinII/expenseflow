@props(['on'])

<div x-data="{
        shown: false,
        timeout: null,
        message: ''
     }"
     x-init="
        $wire.on('{{ $on }}', (event) => {
            clearTimeout(timeout);
            // Get the message from the event
            if (Array.isArray(event) && event.length > 0) {
                message = event[0];
            } else if (typeof event === 'string') {
                message = event;
            }
            shown = true;
            timeout = setTimeout(() => { shown = false }, 3000);
        })
     "
     x-show="shown"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-x-full"
     x-transition:enter-end="opacity-100 transform translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-x-0"
     x-transition:leave-end="opacity-0 transform translate-x-full"
    {{ $attributes->merge(['class' => 'fixed top-4 right-4 z-50 text-sm text-gray-600 dark:text-gray-300']) }}>
    {{ $slot }}
</div>
