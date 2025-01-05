<template>
  <inertia-link 
    :href="link" 
    :title="title"
    class="w-full center select-none py-2 px-2 text-xs 
      leading-none text-black text-center transition-all border-b last:border-b-transparent border-white"
    :class="{
      'bg-yellow-500 first:rounded-t-md last:rounded-b-md': isActive,
      'hover:bg-yellow-500 hover:first:rounded-t-md hover:last:rounded-b-md': !isActive
    }"
  >
    <div class="flex gap-1">
      <div 
        v-if="icon" 
        class="icon w-4 mt-1" 
      > 
        <span v-html="icon" />
      </div>
      <div 
        class="title mt-1 text-xs" 
      > {{ $filters.truncate(title, 25)  }}
      </div>
      <div 
        v-if="value"
        class="mt-1 ml-auto mr-0 rounded-xl bg-sky-900 text-white px-2 py-[0.17rem] text-[0.6rem] h-4 w-8"
      >
        {{ value }}
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
      type: [Number, String],
      required: false
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