<script setup lang="ts">
import { ref, defineProps } from 'vue';

const props = defineProps<{
  isLoading: boolean;
}>();
</script>

<template>
  <div class="loading-screen" v-if="isLoading">
    <div class="loader"></div>
    <p>Loading...</p>
  </div>
</template>

<style scoped>
.loading-screen {
  @apply fixed inset-0 flex flex-col items-center justify-center bg-gray-900 bg-opacity-50 z-50;
}

.loader {
  border: 8px solid #f3f3f3; /* Light grey */
  border-top: 8px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>