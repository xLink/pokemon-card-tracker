<template>
  <div
    id="modal"
    class="flex flex-row z-[100] top-0 left-0 h-full w-full bg-black/40 transition-all absolute justify-center items-center empty:hidden empty:bg-black/0"
    @click.self="closeModal"
  />

  <div id="app" class="min-h-full">
    <Teleport to="#modal">
      <Overlay v-if="modal === 'CardOverlay'" classes=" relative w-fit !rounded-none">
        <CardOverlay :card="card" @close="closeModal" />
      </Overlay>
    </Teleport>
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
      modal: null,
      card: null,
    }
  },

  mounted() {
    this.updatePageTitle(this.title);
    this.$eventBus.$on('open-modal', (card) => {
      this.card = card;
      this.modal = 'CardOverlay';
    });
  },

  methods: {
    updatePageTitle(title) {
      document.title = title ? `${title} | PTCG Tracker` : `PTCG Tracker`
    },
    closeModal() {
      this.modal = null;
      this.card = null;
    },
  },
  
  watch: {
    title(title) {
      this.updatePageTitle(title);
    }
  },

};
</script>