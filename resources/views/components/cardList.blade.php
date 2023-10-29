<div class="flex">
    <div class="flex flex-wrap -mx-2">
        @foreach ($cards as $card)
            @include('components.card', ['card' => $card])
        @endforeach
    </div>
</div>