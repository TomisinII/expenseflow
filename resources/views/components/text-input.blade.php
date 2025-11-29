@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-purple-600 focus:ring-purple-600 rounded-md shadow-sm']) }}>
