<template>
  <div class="flex">
    <div v-if="Object.values(cards).length" class="flex flex-wrap -mx2">
      <Card 
        v-for="card in cards"
        :key="card.id"
        :card="card"
        :active="card.active"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardList',
  props: {
    cards: {
      type: Array|Object,
      required: true
    }
  },
}
</script>