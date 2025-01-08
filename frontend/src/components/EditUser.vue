<script setup lang="ts">
import { ref } from 'vue'
import InputField from './InputField.vue';
import { requiredValidator, emailValidator, passwordValidator, confirmedValidator } from '../utils/validator'


interface User {
  id: number;
  name: string;
  email: string;
  role: string;
  password: string;
  password_confirmation: string;
}

const resetPassword = ref(false)

defineProps<{
  user: User;
}>()

defineEmits<{
  (e: 'back'): void
  (e: 'update-user', user: User): void
}>()


</script>
<template>
  <div class="backdrop">
    <div class="card">
      <h2 class="text-2xl font-bold mb-4 text-center">Edit User</h2>
      <form @submit.prevent="$emit('update-user', user)">
        <InputField 
          class="mb-4" 
          label="Username" 
          v-model="user.name" 
          placeholder="Enter Username" 
          :rules="[requiredValidator]"/>
        <InputField 
          class="mb-4" 
          label="Email" 
          v-model="user.email" 
          placeholder="Enter Email" 
          :rules="[requiredValidator, emailValidator]"
          />
        <div class="flex items-center mb-5">
          <input 
            id="reset-password" 
            v-model="resetPassword" 
            type="checkbox" 
            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
          />
          <label for="reset-password" class="ml-2 block text-sm font-medium text-gray-700">
            reset password
          </label>
        </div>
        <InputField 
          v-if="resetPassword"
          class="mb-4" 
          label="Password" 
          v-model="user.password" 
          type="password"
          placeholder="Enter Password" 
          :rules="[passwordValidator]"
          />
        <InputField 
          v-if="user.password"  
          class="mb-4" 
          label="Password Confirmation" 
          type="password"
          v-model="user.password_confirmation" 
          placeholder="Enter Password Confirmation" 
          :rules="[requiredValidator, () => confirmedValidator(user.password_confirmation, user.password)]"
          />
        <div class="flex justify-between items-center mb-4">
          <button type="button" class="btn-secondary" @click="$emit('back')">Cancel</button>
          <button type="submit" class="btn-primary">Update User</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.backdrop {
  @apply fixed inset-0 flex flex-col items-center justify-center bg-gray-900 bg-opacity-50 z-50;
}

.card {
  @apply w-96 p-6 bg-white rounded-lg shadow-lg;
}
</style>