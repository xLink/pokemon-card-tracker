<template>
  <Layout title="Sets">
    <a 
      v-for="set in sets.data"
      :key="set.id"
      :href="route('pages.sets.single', {set: set.id})"
      class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out"
    >
      <img :src="set.icon" :alt="set.name" class="inline-block" /> {{ set.name }}
    </a>
  </Layout>
</template>

<script>
export default {
  name: 'Sets',
  props: ['sets']
}
</script>