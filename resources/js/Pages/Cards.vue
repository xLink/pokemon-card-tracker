<template>
  <Layout :title="title">
    <CardList :cards="cards" />
  </Layout>
</template>

<script>
export default {
  name: 'Cards',
  props: ['title', 'cards'],
}
</script>