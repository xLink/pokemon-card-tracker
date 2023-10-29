@extends('app')

@section('header', 'TCG Sets')

@section('content')
    @foreach ($sets as $set)
    <a href="{{ route('pages.sets.single', ['set' => $set->id]) }}" class="block"><img src="/{{ $set->icon }}" alt="{{ $set->name }}" class="inline-block"> {{ $set->name }}</a>
    @endforeach
@endsection
