<template>
  <div class="flex">
    <div v-if="Object.values(cards).length" class="flex w-full">
      <table class="table-auto border border-zinc-500 w-full">
        <thead>
          <tr class="group bg-zinc-700 text-white hover:bg-zinc-900 transition-colors duration-150">
            <NeedAuth>
            <th class="px-6 py-3">&nbsp;</th>
            </NeedAuth>
            <th class="px-6 py-3">#</th>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Rarity</th>
            <th class="px-6 py-3">Special</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" class="h-px bg-black">
              &nbsp;
            </td>
          </tr>
          <tr 
            v-for="card, idx in cards"
            class="group even:bg-gray-100 odd:bg-white hover:bg-gray-300 transition-colors duration-150"
            :class="{
              '': collected,
              'opacity-75': !collected,
            }"
          >
            <NeedAuth>
            <td class="px-6 py-3"><input type="checkbox" :id="card.id" :checked="card.collected" /></td>
            </NeedAuth>
            <td class="px-6 py-3">{{ card.card_no }}</td>
            <td class="px-6 py-3" v-html="(card.type ? getIcon(card.type) : '') + ' ' + card.name"></td>
            <td class="px-6 py-3 text-center" v-html="getIcon(card.rarity)"></td>
            <td class="px-6 py-3 text-center">{{ card.special === 'holo' ? 'Reverse Holo' : '' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardList',
  props: {
    cards: {
      type: Array|Object,
      required: true
    }
  },

  methods: {
    getIcon(key) {
      return '<img src="/icons/' + this.slugify(key) + '.png" class="h-5 inline-block" title="' + key + '" />';
    },
    slugify(text) {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    },
    collected(card) {
      return this.$page.props.auth.user.length > 0
        ? card.collected
        : false
      ;
    },
  },

  computed: {
  }
}
</script>