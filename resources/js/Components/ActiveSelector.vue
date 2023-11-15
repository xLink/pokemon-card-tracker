<template>
  <div class="flex flex-col flex-wrap gap-6 w-1/6">

    <div class="flex flex-col p-2 bg-sky-950 rounded pt-3 mt-3">
      <h3 class="text-2xl font-bold -mt-10">Info</h3>
      <ChipLinks title="Total" :value="set_count" :link="total" />
      <NeedAuth class="flex flex-col flex-wrap gap-1">
        <ChipLinks title="Collected" :value="collected" :link="'?collected=1&active=collected&' + request_page" />
        <ChipLinks title="Not Collected" :value="not_collected" :link="'?collected=0&active=collected&' + request_page" />
      </NeedAuth>
      <ChipLinks title="Non Holo" :value="non_holos" :link="'?special=&active=special&' + request_page" />
      <ChipLinks title="Holo" :value="holos" :link="'?special=holo&active=special&' + request_page" />
    </div>

    <div class="flex flex-col p-2 bg-sky-950 rounded pt-3 mt-3">
      <h3 class="text-2xl font-bold -mt-10">Rarity</h3>
      <ChipLinks 
        v-for="value,key in counts.rarity"
        :key="key"
        :title="key"
        :icon="getIcon(key)" 
        :value="value" 
        :link="'?rarity='+key.toLowerCase()+'&active=rarity&' + request_page"
      />
    </div>
    
    <div class="flex flex-col p-2 bg-sky-950 rounded pt-3 mt-3">
      <h3 class="text-2xl font-bold -mt-10">Energy Types</h3>
      <ChipLinks 
        v-for="value,key in counts.etype"
        :key="key"
        :title="key"
        :icon="getIcon(key)" 
        :value="value" 
        :link="'?type='+key.toLowerCase()+'&active=type&' + request_page"
      />
    </div>

    <div class="flex flex-col p-2 bg-sky-950 rounded pt-3 mt-3">
      <h3 class="text-2xl font-bold -mt-10">Card Types</h3>
      <ChipLinks 
        v-for="value,key in counts.ctype"
        :key="key"
        :title="key"
        :value="value" 
        :link="'?card_type='+key.toLowerCase()+'&active=card_type&' + request_page"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'ActiveSelector',

  methods: {
    getIcon(key) {
      return '<img src="/icons/' + this.slugify(key) + '.png" class="h-3 inline-block" title="' + key + '" />';
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
    total() {
      return window.location.pathname + '?page=' + this.page;
    },
    request_page() {
      return 'page=' + this.page;
    },
    page() {
      let params = new URLSearchParams(window.location.search);
      return params.get('page') !== null ? params.get('page') : 1;
    },

    set_count() {
      return this.$page.props.set_count;
    },
    collected() {
      return this.$page.props.collected;
    },
    not_collected() {
      return this.$page.props.not_collected;
    },
    non_holos() {
      return this.$page.props.non_holos;
    },
    holos() {
      return this.$page.props.holos;
    },
    counts() {
      return this.$page.props.counts;
    },
  }
}
</script>