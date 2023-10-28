@extends('app')

@section('header')
TCG Sets > {{ $set->name }} > {{ $card_count }} Cards
@endsection

@section('content')
{!! $cards->links() !!}
<div class="flex justify-between flex-wrap -mx-2">
    @foreach ($cards as $card)
    <div class="w-1/3 px-2 my-2">
        <img src="/{{ $card->image }}" alt="{{ $card->name }}">
    </div>
    @endforeach
</div>
@endsection
