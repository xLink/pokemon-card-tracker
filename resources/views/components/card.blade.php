<div class="{{ implode(' ', [
    'card group relative overflow-hidden transition-all w-1/3 px-2 my-2',
    (isset($card['active']) && !$card['active'] ? 'opacity-30 hover:opacity-70' : 'active')
]) }}">
    @if ($card['special'] === 'holo')
    <div class="group-hover:opacity-0 transition-all duration-300 absolute left-0 top-0 h-16 w-16">
        <div
            class="absolute transform -rotate-45 bg-gray-600 text-center text-white font-semibold py-1 left-[-34px] top-[32px] w-[170px]">
            Holo
        </div>
    </div>
    @endif
    <img src="/{{ $card['image'] }}" alt="{{ $card['name'] }}" class="card__front rounded-xl">
</div>