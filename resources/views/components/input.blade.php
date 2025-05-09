@props(['disabled' => false, 'icon' => null])

<div class="relative">
    @if($icon)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">
                {!! $icon !!}
            </span>
        </div>
    @endif

    <input {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge([
            'class' => 'block w-full ' .
                       ($icon ? 'pl-10 ' : 'pl-4 ') .
                       'pr-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white ' .
                       'focus:border-templax-500 focus:ring-templax-500 dark:focus:border-templax-400 dark:focus:ring-templax-400 ' .
                       'rounded-lg shadow-sm transition-colors duration-200 ease-in-out'
        ]) !!}
    >
</div>
