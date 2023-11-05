<template>
  <div v-if="isntAuthed">
    <slot />
  </div>
</template>

<script>
export default {
  name: 'NoAuth',

  computed: {
    isntAuthed() {
      return this.$page.props.auth.user.length === 0;
    }
  }
}
</script>