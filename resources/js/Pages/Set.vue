<template>
  <Layout :title="title">
    <div class="pb-4">
      <Paginate :links="cards.links" />
    </div>
    <div class="flex flex-row gap-2">
      <div class="flex flex-col flex-wrap gap-1">
        <h3 class="text-2xl font-bold">Info</h3>
        <ChipLinks title="Total" :value="set_count" :link="'?page=' + request_page" />
        <ChipLinks title="Non Holo" :value="non_holos" :link="'?special=&active=special&page=' + request_page" />
        <ChipLinks title="Holo" :value="holos" :link="'?special=holo&active=special&page=' + request_page" />

        <h3 class="text-2xl font-bold">Rarity</h3>
        <ChipLinks 
          v-for="value,key in counts.rarity"
          :key="key"
          :title="key"
          :icon="getIcon(key)" 
          :value="value" 
          :link="'?rarity='+key.toLowerCase()+'&active=rarity&page=' + request_page"
        />
        <h3 class="text-2xl font-bold">Types</h3>
        <ChipLinks 
          v-for="value,key in counts.type"
          :key="key"
          :title="key"
          :icon="getIcon(key)" 
          :value="value" 
          :link="'?type='+key.toLowerCase()+'&active=type&page=' + request_page"
        />
      </div>
      <CardList :cards="cards.data" />
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
    set_count: {
      type: Number,
      required: true
    },
    non_holos: {
      type: Number,
      required: true
    },
    holos: {
      type: Number,
      required: true
    },
    counts: {
      type: Object,
      required: true
    },
  },

  methods: {
    getIcon(key) {
      return '<img src="/icons/' + this.slugify(key) + '.png" class="h-6 inline-block" alt="' + key + '" />';
    },
    slugify(text) {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    },
  },

  computed: {
    request_page() {
      let params = new URLSearchParams(window.location.search);
      return params.get('page');
    },
    title() {
      if (!this.set) { return ''; }
      return ['TCG Sets', this.set.name].join(' > ');
    }
  }
}
</script>