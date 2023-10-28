<a 
    href="{{ route($route) }}" 
    class="px-3 py-2 text-sm font-medium {{
        request()->isCurrentRoute($route.'*') ? 'bg-gray-800 text-white rounded-md' : 'text-gray-300 hover:bg-gray-700 hover:text-white'
    }}"
    {{ request()->isCurrentRoute($route.'*') ? 'aria-current="page"' : '' }}
>{{ $slot }}</a>