<template>
  <div class="absolute top-0 right-0 mr-2 mt-2 z-10">
    <div
      class="p-1 text-white dark:text-zinc-400 hover:text-chks-light-blue-400 cursor-pointer"
      title="Close"
      @click="close_modal()"
    >
      <p class="text-white bg-zinc-500 rounded-lg px-4 py-2 text-lg">x</p>
    </div>
  </div>

  <div
    class="flex flex-col bg-zinc-900 p-2 text-white h-flex justify-between"
  >
    <Card :card="card" />
  </div>
</template>

<script>
export default {
  name: 'CardOverlay',

  props: {
    card: {
      type: Object,
      required: true,
    },
  },

  beforeMount() {
    this.$eventBus.$on('close', () => {
      this.close_modal();
    });
  },
  
  beforeUnmount() {
    this.$eventBus.$off('close');
  },
  
  methods: {
    close_modal() {
      this.$emit('close');
    },
  },
};
</script>
