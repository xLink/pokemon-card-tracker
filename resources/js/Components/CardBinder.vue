<template>
  <div class="flex">
    <div v-if="Object.values(cards).length" class="flex flex-wrap -mx2">
      <Card 
        v-for="card in cards"
        :key="card.id"
        :card="card"
        :active="!!card.active"
        class="mb-4 w-1/3"
        :class="{
          'hidden': showUnselected && !card.active
        }"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'BinderPage',
  props: {
    cards: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      showUnselected: true
    }
  },

  watch: {
    '$page.props': {
      deep: true,
      handler() {
        this.showUnselected = this.$page.props.hide_unselected;
      }
    }
  }
}
</script>