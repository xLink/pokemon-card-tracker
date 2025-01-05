<template>
  <Layout title="Search">

    <div class="flex flex-row">
      <div class="flex flex-col w-[20%] bg-stone-200 rounded-l">
        <ActiveSelector class="w-full" />
      </div>
      <div class="flex flex-col w-[80%]">
        <div class="flex p-2">
          <input name="search" type="text" class="w-full p-2" placeholder="Search for a card" v-model="search" @keyup.enter="submit" />
        </div>
        <div class="flex flex-col p-2">
          <CardBinder :cards="cards.data" />
          <Paginate :links="cards.links" class="ml-2 mb-2" />
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import { router } from '@inertiajs/vue3';

export default {
  name: 'CardSearch',

  data() {
    return {
      search: '',
      cards: {},
      showPageSeperator: true,
    }
  },

  created() {
    this.search = this.$page.props.search;
    this.cards = this.$page.props.cards;
  },

  methods: {
    submit() {
      let params = new URLSearchParams(window.location.search);
      params.set('search', this.search);

      this.$inertia.get('/search', params);
    }
  }
  
}
</script>