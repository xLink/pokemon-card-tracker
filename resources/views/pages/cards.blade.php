@extends('app')

@section('header', $header ?: 'Cards')

@section('content')
    @include('components.cardList', ['cards' => $cards])
@endsection