<template>
  <div v-if="typeof links !== 'undefined' && links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links">
        <div 
          v-if="link.url === null" 
          :key="key+'null'" 
          class="mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border" 
          v-html="link.label" 
        />
        <inertia-link 
          v-else 
          :key="key" 
          class="mb-1 px-4 py-3 text-sm leading-4 border hover:bg-white hover:text-black focus:border-indigo-500 focus:text-indigo-500" 
          :class="{ 'bg-zinc-500 text-white': link.active }" 
          :href="queryStringButPage(link.url)" 
          v-html="pad(link.label, 2, 0)" 
        />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Paginate',
  props: {
    links: {
      type: Array,
      required: true
    },
  },

  methods: {
    queryStringButPage(link) {
      let pageParams = new URLSearchParams(window.location.search);
      let linkParams = new URLSearchParams(link);
      pageParams.set('page', linkParams.get('page'));
      return '?'+pageParams.toString();
    },
    pad(num, size, pad) {
      return num.padStart(size, pad);
    },
  }
}
</script>
