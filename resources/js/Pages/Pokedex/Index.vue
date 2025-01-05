<template>
  <Layout :title="title">
    <div class="flex flex-row flex-wrap">
      <div 
        v-for="pokemon in pokedex" 
        :key="pokemon.id" 
        class="flex flex-col w-1/2 sm:w-1/3 lg:w-1/4 p-2 gap-4"
      >
        <div 
          class="flex flex-col rounded-lg p-1 border-2 border-white hover:border-slate-500 hover:shadow" 
          :style="backgroundColor(pokemon)"
        >
          <div class="text-white/60 text-2xl font-bold text-right">
            #{{ String(pokemon.nat_dex_id).padStart(3, '0') || '000' }}
          </div>
          <div class="flex w-full justify-center items-center -my-4">
            <img 
              :src="`https://assets.pokelink.xyz/assets/sprites/pokemon/home/normal/${speciesName(pokemon)}.png`" 
              :alt="ucwords(pokemon.species)"
              class="w-40"
            />
          </div>
          <div class="text-white/60 text-2xl font-bold text-left">
            {{ pokemon.form || '' }} {{ ucwords(pokemon.species) }}
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import { Pokedex, GAMES } from '@spriteworld/pokemon-data';

export default {
  name: 'PokedexIndex',
  props: {
  },

  data() {
    return {
      pokedex: [],
      typeColors: {
        'bug': '#90c12c',
        'dark': '#5a5366',
        'dragon': '#0a6dc4',
        'electric': '#f3d23b',
        'fairy': '#ec8fe6',
        'fighting': '#ce4069',
        'fire': '#ff9c54',
        'flying': '#8fa8dd',
        'ghost': '#5269ac',
        'grass': '#63bb5b',
        'ground': '#d97746',
        'ice': '#74cec0',
        'normal': '#9099a1',
        'poison': '#ab6ac8',
        'psychic': '#f97176',
        'rock': '#c7b78b',
        'steel': '#5a8ea1',
        'water': '#4d90d5',
        '???': '#68a090'
      },
      forms: {
        'alolan': 'alola',
        'galarian': 'galar',
        'hisuian': 'hisui'
      }
    };
  },

  mounted() {
    this.pokedex = Pokedex.getPokedexByGameId(GAMES.POKEMON_FIRE_RED);
  },

  methods: {
    normalizeSpeciesName(speciesName) {
      if (speciesName.toLowerCase() === 'nidoran (f)') {
        return 'nidoran-f';
      }

      return `${speciesName}`
        .toLowerCase()
        .replace(/[é]/g, 'e')
        .replace(/[♀]/g, '-f')
        .replace(/ \(m\)/g, '')
        .replace(/[^a-zA-Z0-9♀]/g, '')
      ;
    },
    speciesName(pokemon) {
      let normalize = this.normalizeSpeciesName(pokemon.species);
      let form = '';
      if (pokemon.form.length > 0) {
        form = pokemon.form.toLowerCase();
        if (this.forms[form]) {
          form = this.forms[form];
        }

        if (form === 'normal') {
          return normalize;
        }

        return [normalize, form].join('-');
      }

      return normalize;
    },
    ucwords(str) {
      return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
          return letter.toUpperCase();
      });
    },
    typeColor(type) {
      if (typeof type === 'undefined') {
        return this.typeColors['???'];
      }
      type = type.toLowerCase();
      return this.typeColors[type];
    },
    backgroundColor(pokemon) {
      if (pokemon.types === null) {
        return 'background-color: ' + this.typeColor('???') + ';'
      }

      if (pokemon.types.length === 1) {
        return 'background-color: ' + this.typeColor(pokemon.types[0]) + ''
      }

      return 'background: linear-gradient(32.5deg, ' 
        + this.typeColor(pokemon.types[0]) + ' 0%, ' 
        + this.typeColor(pokemon.types[0]) + ' 50%, ' 
        + 'rgba(240, 240, 240, 0.8) 50%, ' 
        + this.typeColor(pokemon.types[1]) + ' 51%,'
        + this.typeColor(pokemon.types[1]) + ' 100%)'
    },
    topPokeballColor(pokemon) {
      if (pokemon.types === null) {
        return this.typeColor('???');
      }
      
      return this.typeColor(pokemon.types[0]);
    },
    bottomPokeballColor(pokemon) {
      if (pokemon.types === null) {
        return this.typeColor('???');
      }
      if (pokemon.types.length === 1) {
        return this.typeColor(pokemon.types[0]);
      }
      
      return this.typeColor(pokemon.types[1]);
    },
  },

  computed: {
    title() {
      return 'Pokédex';
    },
  }
}
</script>