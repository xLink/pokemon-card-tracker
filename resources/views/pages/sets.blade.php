@extends('app')

@section('header', 'TCG Sets')

@section('content')
<ul>
    @foreach ($sets as $set)
    <li><a href="{{ route('pages.sets.single', ['set' => $set->id]) }}">{{ $set->name }}</a></li>
    @endforeach
</ul>
@endsection
