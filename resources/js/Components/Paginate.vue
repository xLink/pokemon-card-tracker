<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links">
        <div 
          v-if="link.url === null" 
          :key="key" 
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" 
          v-html="link.label" 
        />
        <inertia-link 
          v-else 
          :key="key" 
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" 
          :class="{ 'bg-zinc-500 text-white': link.active }" 
          :href="queryStringButPage(link.label)" 
          v-html="link.label" 
        />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Paginate',
  props: {
    links: Array,
  },

  methods: {
    queryStringButPage(page) {
      let params = new URLSearchParams(window.location.search);
      params.set('page', page);
      return '?'+params.toString();
    }
  }
}
</script>
