<template>
  <div v-if="visible" class="redirect-block">
    <span class="redirect-image"></span><br>
    <span class="redirect-text">{{ text }}</span>
  </div>
</template>

<script>
  import StaticElement from '@laraform/laraform/src/components/elements/StaticElement'

  export default {
    mixins: [StaticElement],
    computed: {
      text() {
        return this.schema.text
      }
    },
  }
</script>>