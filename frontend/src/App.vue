<script setup lang="ts">
import Navbar from './components/Navbar.vue'

const user = localStorage.getItem('user')
</script>

<template>
  <div class="flex flex-col min-h-screen">
    <main class="flex-grow">
      <router-view></router-view>
    </main>
  </div>
</template>

<style scoped>
.sticky {
  position: sticky;
  top: 0;
}
</style>