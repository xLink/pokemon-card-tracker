<template>
  <div
    class="card group relative overflow-hidden transition-all w-1/3 px-2 my2"
    :class="{
      'opacity-30 hover:opacity-70': !active(),
      'active': active()
    }"
  >
    <img :src="'/' + card.image" :alt="card.name" class="card__front rounded-xl">
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: {
    card: {
      type: Object,
      required: true
    },
  },

  methods: {
    active() {
      // active not set? default to true
      if (typeof this.card.active === 'undefined') {
        return true;
      }
      // disable if active is set and false
      if (!this.card.active) {
        return false;
      }

      // default to true for anything else
      return true;
    }
  }
}
</script>