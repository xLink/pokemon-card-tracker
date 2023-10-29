@extends('app')

@section('header')
TCG Sets > {{ $set->name }}
@endsection

@section('content')
<div class="pb-4">
    {!! $cards->appends(request()->except('page'))->links() !!}
</div>

<div class="flex flex-row gap-2">
    <div class="flex flex-col flex-wrap gap-1">
        <h3>Info</h3>
        @include('components.chipLinks', [
            'key' => 'Total', 
            'value' => $set_count,
            'link' => '?page='.request()->get('page', 1),
        ])
        @include('components.chipLinks', [
            'key' => 'Non Holos', 
            'value' => $non_holos,
            'link' => '?special=&active=special&page='.request()->get('page', 1),
        ])
        @include('components.chipLinks', [
            'key' => 'Holos', 
            'value' => $holos,
            'link' => '?special=holo&active=special&page='.request()->get('page', 1),
        ])
        @foreach($counts as $title => $count)
            <h3>{{ ucwords(Str::plural($title)) }}</h3>
            @foreach($count as $key => $value)
                @include('components.chipLinks', [
                    'key' => $key,
                    'icon' => sprintf('<img src="/icons/%s.png" title="%s" class="h-6 inline-block" />', Str::slug(strtolower($key)), $key), 
                    'value' => $value,
                    'link' => '?'. $title .'=' . $key.'&active='.$title.'&page='.request()->get('page', 1),
                ])
            @endforeach
        @endforeach
    </div>

    @include('components.cardList', ['cards' => $cards])
</div>

@endsection
