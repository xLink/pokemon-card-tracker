<template>
  <inertia-link :href="link">
    <div 
      class="w-full center relative inline-block select-none whitespace-nowrap rounded-lg 
        bg-blue-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase 
        leading-none text-white text-center tracking-wide shadow-lg hover:bg-blue-600 transition-all"
    >
      <div class="flex justify-around gap-1">
        <div 
          v-if="icon" 
          class="text-center icon" 
          v-html="icon"> 
        </div>
        <div 
          v-else 
          class="text-center title" 
        > {{ title }}
        </div>
        <div class="text-center align-middle">
          {{ value }}
        </div>
      </div>
    </div>
  </inertia-link>
</template>

<script>
export default {
  name: 'ChipLink',
  props: {
    link: {
      type: String,
      required: true
    },
    icon: {
      type: String,
      required: false,
      default: null,
    },
    title: {
      type: String,
      required: false,
      default: null
    },
    value: {
      type: Number,
      required: true
    }
  },
}
</script>