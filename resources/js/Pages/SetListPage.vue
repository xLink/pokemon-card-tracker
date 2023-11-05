<template>
  <Layout :title="title">
    <CardList :cards="cards" />
  </Layout>
</template>

<script>
export default {
  name: 'Set',
  props: {
    set: {
      type: Object,
      required: true
    },
    cards: {
      type: Array,
      required: true
    },
    set_count: {
      type: Number,
      required: true
    },
    collected: {
      type: Number,
      required: true
    },
    not_collected: {
      type: Number,
      required: true
    },
    non_holos: {
      type: Number,
      required: true
    },
    holos: {
      type: Number,
      required: true
    },
  },

  methods: {
    getIcon(key) {
      return '<img src="/icons/' + this.slugify(key) + '.png" class="h-6 inline-block" alt="' + key + '" />';
    },
    slugify(text) {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    },
  },

  computed: {
    request_page() {
      let params = new URLSearchParams(window.location.search);
      return params.get('page');
    },
    title() {
      if (!this.set) { return ''; }
      return ['TCG Sets', this.set.name].join(' > ');
    }
  }
}
</script>