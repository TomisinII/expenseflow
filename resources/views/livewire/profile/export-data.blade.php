<div>
    <div class="flex items-center justify-between gap-4">
        <div>
            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Export Data</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Download all your expense data as CSV
            </p>
        </div>
        <x-secondary-button wire:click="exportAllData" wire:loading.attr="disabled">
            <svg wire:loading.remove wire:target="exportAllData" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor" class="mr-2">
                <path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
            </svg>
            <svg wire:loading wire:target="exportAllData" class="animate-spin -ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="exportAllData">Export</span>
            <span wire:loading wire:target="exportAllData">Exporting...</span>
        </x-secondary-button>
    </div>
</div>
