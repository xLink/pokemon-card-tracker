<template>
  <Layout :title="title">
    <div class="flex flex-row">
      <div class="flex flex-col w-[20%] bg-stone-200 rounded-l">
        <ActiveSelector class="w-full" />
      </div>
      <div class="flex flex-col w-[80%]">
        <div class="flex flex-col pb-4 justify-between">
          <div class="flex w-full bg-stone-300 pl-4 pt-2 rounded-r">
            <inertia-link 
              class="flex items-center flex-shrink-0 px-5 py-3 mr-2 space-x-2 bg-white text-black border border-b-0 border-b-transparent rounded-t-lg" 
              :href="route('pages.sets.single', set)"
            >
              View Binder
            </inertia-link>
            <inertia-link 
              class="flex items-center flex-shrink-0 px-5 py-3 space-x-2 bg-stone-200 text-gray-500 hover:bg-white border-b hover:border-b-0 hover:border-b-transparent  rounded-t-lg" 
              :href="route('pages.sets.single-list', set)"
            >
              View List
            </inertia-link>
          </div>
          <div class="flex">
            
          </div>
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
export default {
  name: 'Set',
  props: {
    set: {
      type: Object,
      required: true
    },
    cards: {
      type: Object,
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