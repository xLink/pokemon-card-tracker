<template>
  <Layout title="Sets">
    <div class="flex flex-wrap gap-2 px-5 py-6">
      <div 
        v-for="set in sets"
        @click="gotoSet(set)"
        class="relative group flex flex-col w-[32.8%] h-28 p-2.5 rounded border overflow-hidden hover:cursor-pointer hover:bg-zinc-800 hover:text-white"
      >
        <div class="opacity-25 absolute w-full h-full z-9" 
          :style="{
            'background-image': 'url(' + set.logo + ')',
            'background-size': '50%',
            'background-repeat': 'no-repeat',
            'background-position': 'center center',
            'background-opacity': '0.5'
          }"
        >&nbsp;</div>
        <div class="flex flex-col z-10">
          <div class="flex items-center h-6">
            <img :src="set.icon" :alt="set.name" class="inline-block h-fit mr-1" @error="(e) => e.target.classList.toggle('hidden')" /> {{ set.name }}
          </div>

          <div class="flex flex-row text-xs">
            <div class="flex w-1/6">
              {{ set.collected }} / {{ set.set_count }}
            </div>
            <div class="flex w-5/6">
              <ProgressBar 
                :min="0" 
                :max="set.set_count" 
                :value="set.collected" 
                title="Collected"
                class="w-[79%]"
              />
            </div>
          </div>
          <div class="flex flex-col text-xs">
            <div class="flex w-full justify-end pt-2">
              <a 
                :href="route('pages.sets.single', {set: set.id})" 
                class="mb-1 px-4 py-3 text-sm leading-4 border bg-white hover:bg-zinc-800 group-hover:text-white group-hover:bg-zinc-800 focus:border-indigo-500 focus:text-indigo-500"
              >View Set</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import { router } from '@inertiajs/vue2';

export default {
  name: 'Sets',
  props: ['sets'],

  methods: {
    gotoSet(set) {
      router.get(route('pages.sets.single', {set: set.id}));
    }
  }
}
</script>