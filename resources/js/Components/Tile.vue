<template>
  <div
    class="flex flex-col h-20 w-48 justify-end bg-zinc-400 rounded-lg shadow-lg px-4 py-2 relative overflow-hidden"
    :style="'background-color: '+color+';'"
  >

    <span
      class="z-20 text-white text-sm font-bold"
      v-text="label"
    />
  </div>
</template>

<script>
export default {
  name: 'Tile',
  props: {
    label: {
      type: String,
      required: false,
      default: '',
    },
    color: {
      type: String,
      required: false,
      default: '#52525b',
    },
  },
}
</script>