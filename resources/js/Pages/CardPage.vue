<template>
  <div class="flex flex-wrap">
    <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-2">
      {!! $card->toArray() !!}
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: ['title', 'card'],
}
</script>