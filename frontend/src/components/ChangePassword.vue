<script setup lang="ts">
import { ref } from 'vue'
import { requiredValidator, passwordValidator, confirmedValidator } from '../utils/validator'
import { useUserStore } from '../stores/users'
import InputField from './InputField.vue'
import LoadingScreen from '../components/LoadingScreen.vue'

const userStore = useUserStore()

const props = defineProps<{
  email: string
}>()
// Snackbar state
const showSnackbar = ref(false)
const snackbarMessage = ref('')
const snackbarType = ref('success')

const isLoading = ref(false)

const form = ref({
  email: props.email,
  password: null,
  password_confirmation: null,
})

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  snackbarMessage.value = message
  snackbarType.value = type
  showSnackbar.value = true
  setTimeout(() => {
    showSnackbar.value = false
  }, 3000)
}

const handleSubmit = async () => {
  isLoading.value = true
  const payload = {
    email: props.email,
    password: form.value.password,
    password_confirmation: form.value.password_confirmation
  }
  try {
    await userStore.resetPassword(payload)
    await showNotification('Password changed successfully')
  } catch (err: any) {
    console.error('Password change error:', err)
    showNotification('Failed to change password', 'error')
  } finally {
    isLoading.value = false
    window.location.href = '/login'
  }
}
</script>

<template>
  <LoadingScreen :isLoading="isLoading" />
  <div class="card max-w-md w-full space-y-8 p-8">
    <!-- Snackbar -->
    <div
      v-if="showSnackbar"
      :class="[
        'fixed top-15 right-4 px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300',
        snackbarType === 'success' ? 'bg-green-500' : 'bg-red-500'
      ]"
    >
      <p class="text-white">{{ snackbarMessage }}</p>
    </div>
    <div>
      <div class="text-center text-4xl mb-2">📚</div>
      <h2 class="mt-4 text-center text-3xl font-extrabold text-gray-900">
        Change Password {{ form.email }}
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        If you have forgotten your password, you can reset it here
      </p>
    </div>

    <div class="space-y-4">
      <div>
        <InputField
          label="Password"
          v-model="form.password"
          type="password"
          placeholder="Enter Password"
          :rules="[requiredValidator, passwordValidator]"
        />
      </div>

      <div>
        <InputField
          label="Confirm Password"
          v-model="form.password_confirmation"
          type="password"
          placeholder="Confirm Password"
          :rules="[requiredValidator, () => confirmedValidator(form.password_confirmation, form.password)]"
        />
      </div>
    </div>

    <div>
      <button
        class="btn-primary w-full flex justify-center"
        @click="handleSubmit"
      >
        Change Password
      </button>
    </div>
  </div>
</template>