@props(['active' => false])
<a class="{{ $active ? 'dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
    aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>{{ $slot }}</a>
