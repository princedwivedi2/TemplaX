@props(['id', 'label'])

<div class="flex items-center">
    <input 
        type="checkbox" 
        id="{{ $id }}" 
        {{ $attributes->merge([
            'class' => 'w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-templax-600 dark:text-templax-500 shadow-sm focus:border-templax-300 focus:ring focus:ring-templax-200 focus:ring-opacity-50 dark:focus:ring-templax-600 dark:focus:ring-opacity-30 dark:bg-gray-700 transition-colors duration-200 ease-in-out'
        ]) }}
    >
    <label for="{{ $id }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
        {{ $label }}
    </label>
</div>
