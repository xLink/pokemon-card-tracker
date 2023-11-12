<template>
<div class="absolute bg-neutral-200 dark:bg-neutral-600">
  <div
    class="bg-blue-600 p-0.5 text-center text-xs font-medium leading-none text-white"
    :style="'width: ' + percentage + '%'"
  >&nbsp;</div>
  <div class="relative -mt-4 p-0.5 text-center text-xs font-medium leading-none text-white">
    {{ percentage }}% {{ title || ''}}
  </div>
</div>
</template>

<script>
export default {
  name: 'ProgressBar',
  props: {
    min: {
      type: Number,
      default: 0
    },
    max: {
      type: Number,
      default: 100
    },
    value: {
      type: Number,
      default: 0
    },
    title: {
      type: String,
      default: ''
    },
    show: {
      type: String,
      default: 'value',
      Validator: (value) => {
        return ['value', 'percentage'].includes(value);
      }
    }
  },

  computed: {
    percentage() {
      return ((this.value / this.max) * 100).toFixed(0);
    }
  }
}
</script>