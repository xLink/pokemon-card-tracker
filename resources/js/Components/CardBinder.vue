<template>
  <div class="flex">
    <div v-if="Object.values(cards).length" class="flex flex-wrap -mx2">
      <Card 
        v-for="card in cards"
        :key="card.id"
        :card="card"
        :active="!!card.active"
        class="mb-4"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'BinderPage',
  props: {
    cards: {
      type: Array|Object,
      required: true
    }
  },
}
</script>