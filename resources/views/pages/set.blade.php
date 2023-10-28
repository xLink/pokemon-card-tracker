@extends('app')

@section('header')
TCG Sets > {{ $set->name }} > {{ $set_count }} Cards
@endsection

@section('content')
{!! $cards->links() !!}

<div class="flex">
    Non Holos: {{ $non_holos }} | Holos: {{ $holos }}
</div>

<div class="flex flex-wrap -mx-2">
    @foreach ($cards as $card)
    <div class="group relative overflow-hidden w-1/3 px-2 my-2">
        @if ($card['special'] === 'holo')
        <div class="group-hover:opacity-0 transition-all duration-300 absolute left-0 top-0 h-16 w-16">
            <div
                class="absolute transform -rotate-45 bg-gray-600 text-center text-white font-semibold py-1 left-[-34px] top-[32px] w-[170px]">
                Holo
            </div>
        </div>
        @endif
        <img src="/{{ $card['image'] }}" alt="{{ $card['name'] }}" class="rounded-xl">
    </div>
    @endforeach
</div>
@endsection
