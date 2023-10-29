<a href="{{ $link }}">
    <div 
        class="w-full center relative inline-block select-none whitespace-nowrap rounded-lg 
        bg-blue-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase 
        leading-none text-white text-center tracking-wide shadow-lg hover:bg-blue-600 transition-all
        {{ (request()->has('active') && request()->get(request()->get('active')) === $key) ? 'bg-red-600' : '' }}
        "
    >
        <span>{!! $icon ?? $key !!} ({{ $value }})</span>
    </div>
</a>