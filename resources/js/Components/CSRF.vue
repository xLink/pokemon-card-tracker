<template>
  <input type="hidden" name="_token" :value="csrf">
</template>

<script>
/**
* Laravel CSRF Token hidden input.
* 
* The following is required in the header of the blade file responsible for containing the HTML header info:
* <meta name="csrf-token" content="{{ csrf_token() }}">
*/
export default {
  name: 'CSRF',

  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }
  },
}
</script>