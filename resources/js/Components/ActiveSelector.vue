<template>
  <div class="flex flex-col flex-wrap py-2 px-4">
    <div class="flex">
      <h3 class="text-sm uppercase font-bold mb-2 mt-6">Info</h3>
    </div>
    <div class="flex flex-col bg-stone-300 rounded-md">
      <ChipLink title="Total" :value="set_count" :link="total + search" />
      <ChipLink v-if="collected !== 0 && !compare_user" title="Collected" :value="collected" :link="getParams({collected: '1', active: 'collected'})" />
      <ChipLink v-if="collected !== 0 && !compare_user" title="Not Collected" :value="not_collected" :link="getParams({collected: '0', active: 'collected'})" />
      <ChipLink title="Non Holo" :value="non_holos" :link="getParams({special: '', active: 'special'})" />
      <ChipLink title="Holo" :value="holos" :link="getParams({special: 'holo', active: 'special'})" />
    </div>
    <div class="flex" v-if="compare_user">
      <h3 class="text-sm uppercase font-bold mb-2 mt-6">User Compare</h3>
    </div>
    <div class="flex flex-col bg-stone-300 rounded-md" v-if="compare_user">
      <ChipLink :title="user1_name + ' Collected'" :value="user1_collected" :link="getParams({user1_collected: 'true', active: 'user1_collected'})" />
      <ChipLink :title="user1_name + ' Missing'" :value="user1_missing" :link="getParams({user1_missing: 'true', active: 'user1_missing'})" />
      <ChipLink :title="user2_name + ' Collected'" :value="user2_collected" :link="getParams({user2_collected: 'true', active: 'user2_collected'})" />
      <ChipLink :title="user2_name + ' Missing'" :value="user2_missing" :link="getParams({user2_missing: 'true', active: 'user2_missing'})" />
      <ChipLink title="Both Collected" :value="both_collected" :link="getParams({both_collected: 'true', active: 'both_collected'})" />
      <ChipLink title="Neither Collected" :value="non_collected" :link="getParams({non_collected: 'true', active: 'non_collected'})" />
    </div>

    <div class="flex">
      <h3 class="text-sm uppercase font-bold mb-2 mt-6">Rarity</h3>
    </div>
    <div class="flex flex-col bg-stone-300 rounded-md">
      <ChipLink 
        v-for="value,key in counts.rarity"
        :key="key"
        :title="key"
        :icon="getIcon(key)" 
        :value="value" 
        :link="getParams({rarity: key.toLowerCase(), active: 'rarity'})"
      />
    </div>
      
    <div class="flex">
      <h3 class="text-sm uppercase font-bold mb-2 mt-6">Energy Types</h3>
    </div>
    <div class="flex flex-col bg-stone-300 rounded-md">
      <ChipLink 
        v-for="value,key in counts.etype"
        :key="key"
        :title="key"
        :icon="getIcon(key)" 
        :value="value" 
        :link="getParams({type: key.toLowerCase(), active: 'type'})"
      />
    </div>
    
    <div class="flex">
      <h3 class="text-sm uppercase font-bold mb-2 mt-6">Card Types</h3>
    </div>
    <div class="flex flex-col bg-stone-300 rounded-md">
      <ChipLink 
        v-for="value,key in counts.ctype"
        :key="key"
        :title="key"
        :value="value" 
        :link="getParams({card_type: key.toLowerCase(), active: 'card_type'})"
      />
    </div>
    
    <div class="flex">
      <h3 class="text-sm uppercase font-bold mb-2 mt-6">Options</h3>
    </div>
    <div class="flex flex-col bg-stone-300 rounded-md">
      <ChipLink 
        v-if="params.get('hide') === 'true'"
        title="Show Unselected"
        :link="getParams({hide: false})"
      />
      <ChipLink 
        v-else
        title="Hide Unselected"
        :link="getParams({hide: true})"
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
    getParams(options) {
      let params = new URLSearchParams(window.location.search);
      for (const [key, value] of Object.entries(options)) {
        params.set(key, value);
      }      
      return '?' + params.toString();
    },
  },

  computed: {
    params() {
      return new URLSearchParams(window.location.search);
    },
    total() {
      return window.location.pathname + '?page=' + this.page + '&';
    },
    request_page() {
      return 'page=' + this.page + '&';
    },
    search() {
      if (this.$page.props.search === undefined) {
        return '';
      }
      return 'search=' + this.$page.props.search + '&';
    },
    hide_unselected() {
      let params = new URLSearchParams(window.location.search);
      params.set('hide', params.get('hide') === 'true' ? 'false' : 'true');
      return params.toString();
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

    compare_user() {
      return this.$page.props.compare_user ?? false;
    },
    user1_name() {
      let user = this.$page.props.user1;

      if (user.name.length > 0) {
        return user.name;
      }

      return user.friend_id;
    },
    user1_collected() {  return this.$page.props.user1_collected; },

    user2_name() {
      let user = this.$page.props.user2;

      if (user.name.length > 0) {
        return user.name;
      }

      return user.friend_id;
    }, 
    user2_collected() { return this.$page.props.user2_collected; },
    both_collected() { return this.$page.props.both_collected; },
    non_collected() { return this.$page.props.non_collected; },
    user1_missing() { return this.$page.props.user1_missing; },
    user2_missing() { return this.$page.props.user2_missing; },
  }
}
</script>