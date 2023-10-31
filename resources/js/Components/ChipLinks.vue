<template>
  <inertia-link :href="link">
    <div 
      class="w-full center relative inline-block select-none whitespace-nowrap rounded-lg 
         py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase 
        leading-none text-white text-center tracking-wide shadow-lg transition-all"
      :class="{
        'bg-red-500 hover:bg-red-600 ': isActive,
        'bg-blue-500 hover:bg-blue-600 ': !isActive
      }"
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

  computed: {
    isActive() {
      let pageParams = new URLSearchParams(window.location.search);
      let linkParams = new URLSearchParams(this.link);
      
      if (linkParams.get('active') === pageParams.get('active') && pageParams.get(linkParams.get('active')) === linkParams.get(linkParams.get('active'))) {
        return true;
      }

      return false;
    }
  }
}
</script>