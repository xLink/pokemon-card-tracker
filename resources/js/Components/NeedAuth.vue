<template>
  <div v-if="isAuthed">
    <slot />
  </div>
</template>

<script>
export default {
  name: 'NeedAuth',

  computed: {
    isAuthed() {
      return this.$page.props.auth.user.length !== 0;
    }
  }
}
</script>