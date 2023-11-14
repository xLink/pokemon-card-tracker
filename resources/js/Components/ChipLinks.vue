<template>
  <inertia-link :href="link" :title="title">
    <div 
      class="w-full center select-none py-2 px-3.5 text-xs font-bold uppercase 
        leading-none text-black text-center transition-all border-b border-transparent"
      :class="{
        'bg-zinc-200': isActive,
        'hover:bg-zinc-200': !isActive
      }"
    >
      <div class="flex gap-1">
        <div 
          v-if="icon" 
          class="icon" 
          v-html="icon"> 
        </div>
        <div 
          v-else 
          class="title" 
        > {{ title }}
        </div>
        <div class="inline-block align-middle">
          ({{ value }})
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