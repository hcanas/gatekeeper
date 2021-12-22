<template>
  <component :is="layout + '-layout'">
    <router-view :key="$route.fullPath"></router-view>
  </component>
</template>
<script>
  import CleanLayout from './components/layouts/CleanLayout.vue';
  import MainLayout from './components/layouts/MainLayout.vue';
  
  export default {
    name: 'App',
    components: {
      MainLayout,
      CleanLayout,
    },
    data() {
      return {
        layout: this.$store.getters['getUser'] ? 'main' : 'clean',
      }
    },
    computed: {
      user() {
        return this.$store.getters['getUser'];
      },
    },
    watch: {
      user(val) {
        if (val) {
          this.layout = 'main';
        } else {
          this.layout = 'clean';
        }
      },
    },
  }
</script>
