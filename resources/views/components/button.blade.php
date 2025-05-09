<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'w-full inline-flex justify-center items-center px-6 py-3 bg-templax-600 dark:bg-templax-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-templax-500 dark:hover:bg-templax-600 active:bg-templax-700 dark:active:bg-templax-800 focus:outline-none focus:border-templax-700 dark:focus:border-templax-600 focus:ring ring-templax-300 dark:ring-templax-500 disabled:opacity-25 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg'
]) }}>
    {{ $slot }}
</button>
