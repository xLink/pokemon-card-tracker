<template>
  <Layout :title="title">
    <div class="flex pb-4 justify-between">
      <div class="flex">
        <inertia-link class="mb-1 px-4 py-3 text-sm leading-4 border hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :href="route('pages.sets.single', set)">View Binder</inertia-link>
        <inertia-link class="bg-zinc-500 text-white mb-1 px-4 py-3 text-sm leading-4 border hover:bg-white hover:text-black focus:border-indigo-500 focus:text-indigo-500" :href="route('pages.sets.single-list', set)">View List</inertia-link>
      </div>
      <div class="flex">

      </div>
    </div>
    <div class="flex flex-row gap-2">
      <ActiveSelector />
      <CardList :cards="cards" />
    </div>
  </Layout>
</template>

<script>
export default {
  name: 'Set',
  props: {
    set: {
      type: Object,
      required: true
    },
    cards: {
      type: Array,
      required: true
    },
  },

  computed: {
    title() {
      if (!this.set) { return ''; }
      return ['TCG Sets', this.set.name].join(' > ');
    }
  }
}
</script>