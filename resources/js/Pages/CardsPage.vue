<template>
  <Layout :title="title">
    <CardBinder :cards="cards" />
  </Layout>
</template>

<script>
export default {
  name: 'Cards',
  props: ['title', 'cards'],
}
</script>