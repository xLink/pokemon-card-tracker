<template>
  <div class="flex w-full">
    <div v-if="Object.values(cards).length" class="flex flex-col w-full">
      <div class="flex">
        <div class="flex">
          <label for="showPageSeperator" class="p-2">
            <input type="checkbox" id="showPageSeperator" v-model="showPageSeperator"> Show Page Seperator
          </label>
        </div>
        <div class="flex mr-0 ml-auto">
          <label for="searchTerm" class="">
            <input 
              type="text" 
              id="searchTerm" 
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
              v-model="searchTerm"
              placeholder="Search For Card"
            />
          </label>
        </div>
        <div class="flex">

        </div>
      </div>
      <table class="table-auto border border-zinc-500 w-full">
        <thead>
          <tr class="group bg-zinc-700 text-white hover:bg-zinc-900 transition-colors duration-150">
            <NeedAuth>
            <th class="w-1/6 px-6 py-3">&nbsp;</th>
            </NeedAuth>
            <th class="w-1/6 px-6 py-3">#</th>
            <th class="w-2/6 px-6 py-3">Name</th>
            <th class="w-1/6 px-6 py-3">Rarity</th>
            <th class="w-1/6 px-6 py-3">Type</th>
            <th class="w-1/6 px-6 py-3">Special</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="(card, idx) in cardSearch"
            class="group even:bg-gray-100 odd:bg-white hover:bg-gray-300 transition-colors duration-150"
            :class="{
              '': collected,
              'opacity-75': !collected,
              'hidden opacity-30 hover:opacity-70': !card.active,
              'active': card.active,
              'border-b border-black': showPageSeperator && parseInt(idx+1) % parseInt($page.props.pagination) === 0,
            }"
          >
            <NeedAuth>
            <td class="w-1/6 px-6 py-3 text-center">
              <input 
                type="checkbox" 
                :key="card.id" 
                :id="card.id" 
                :checked="card.collected" 
                @click="collectCard(card)" 
              />
            </td>
            </NeedAuth>
            <td class="w-1/6 px-6 py-3">{{ card.card_no }}</td>
            <td class="w-2/6 px-6 py-3" v-html="(card.type ? getIcon(card.type) : '') + ' ' + card.name"></td>
            <td class="w-1/6 px-6 py-3 text-center" v-html="getIcon(card.rarity)"></td>
            <td class="w-1/6 px-6 py-3 text-center">{{ card.card_type }}</td>
            <td class="w-1/6 px-6 py-3 text-center">{{ card.special === 'holo' ? 'Reverse Holo' : '' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="" v-else>
      <p>No Cards Found</p>
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

  data() {
    return {
      showPageSeperator: true,
      searchTerm: null
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
    collectCard(card) {
      if (this.$page.props.auth.user.length > 0) {
        console.log('User is not logged in');
        return false;
      }

      axios.post(route('pages.cards.collect', {card: card.id}))
        .then(response => {
          card.cardList = response.data.cards;
        })
        .catch(error => {
          console.log(error);
        })
      ;
    },
  },

  computed: {
    cardSearch() {
      if (this.searchTerm === null || this.searchTerm.length === 0) {
        this.showPageSeperator = true;
        return this.cards;
      }

      this.showPageSeperator = false;
      return this.cards.filter(card => {
        if (card.name !== null && card.name.toString().toLowerCase().includes(this.searchTerm.toLowerCase())) {
          return true;
        }

        if (card.card_no !== null && card.card_no.toString().toLowerCase().includes(this.searchTerm.toLowerCase())) {
          return true;
        }

        if (card.type !== null && card.type.toString().toLowerCase() == this.searchTerm.toLowerCase()) {
          return true;
        }

        if (card.rarity !== null && card.rarity.toString().toLowerCase() == this.searchTerm.toLowerCase()) {
          return true;
        }

        if (card.card_type !== null && card.card_type.toString().toLowerCase() == this.searchTerm.toLowerCase()) {
          return true;
        }

        if (card.special !== null && card.special.toString().toLowerCase() == this.searchTerm.toLowerCase()) {
          return true;
        }

        return false;
      });
    }
  },
}
</script>