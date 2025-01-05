<template>
  <div
    class="card group relative overflow-hidden transition-all w-1/3 px-2 my2"
    :class="{
      'opacity-30 hover:opacity-70': !active,
      'active': active
    }"
  >
    <img :src="'/' + card.image" :alt="card.name" class="card__front rounded-xl">
  </div>
</template>

<script>
export default {
  name: 'Card',
  components: {
  },

  props: {
    card: {
      type: Object,
      required: true
    },
    active: {
      type: Boolean,
      default: true
    }
  },
}
</script>