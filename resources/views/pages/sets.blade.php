@extends('app')

@section('header')
TCG Sets
@endsection

@section('content')
    @foreach ($sets as $set)
        <a href="{{ route('pages.sets.single', ['set' => $set->id]) }}">{{ $set->name }}</a>
    @endforeach
@endsection
