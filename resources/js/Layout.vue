<template>
  <div id="app" class="min-h-full">
    <div class="bg-gray-800 pb-32">
      <Navigation></Navigation>
      <header class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-white">
            {{ title ?? 'Title' }}
          </h1>
        </div>
      </header>
    </div>

    <main class="-mt-32">
      <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white shadow">
          <slot></slot>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'Layout',
  props: ['title'],

  data() {
    return {

    }
  },

  mounted() {
    this.updatePageTitle(this.title);
  },

  methods: {
    updatePageTitle(title) {
      document.title = title ? `${title} | PTCG Tracker` : `PTCG Tracker`
    },
  },
  
  watch: {
    title(title) {
      this.updatePageTitle(title);
    }
  },

};
</script>