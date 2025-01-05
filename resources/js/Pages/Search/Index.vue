<template>
  <Layout title="Search">
    <div class="flex p-2">
      <input name="search" type="text" class="w-full p-2" placeholder="Search for a card" v-model="search" @keyup.enter="submit" />
    </div>
  </Layout>
</template>

<script>
export default {
  name: 'Search',

  data() {
    return {
      search: ''
    }
  },

  methods: {
    submit() {
      this.$inertia.get('/search', {
        search: this.search
      });
    }
  }
}
</script>