<script setup lang="ts">
import { ref } from 'vue'
import InputField from '../components/InputField.vue'
import { requiredValidator, emailValidator, passwordValidator, confirmedValidator } from '../utils/validator'
import { useUserStore } from '../stores/users'
import router from '../router';
import LoadingScreen from '../components/LoadingScreen.vue'

const userStore = useUserStore()

// Snackbar state
const showSnackbar = ref(false)
const snackbarMessage = ref('')
const snackbarType = ref('success')

const isLoading = ref(false)
const error = ref('')
const form = ref({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
  is_admin: false
})

const clearForm = () => {
  form.value = {
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    is_admin: false
  }
}

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  snackbarMessage.value = message
  snackbarType.value = type
  showSnackbar.value = true
  setTimeout(() => {
    showSnackbar.value = false
  }, 3000)
}

const handleSubmit = async () => {
  error.value = ''
  isLoading.value = true
  try {
    await userStore.Register(form.value)
    await showNotification('Registration successful')
    clearForm()
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Registration failed. Please try again.'
    showNotification(error.value, 'error')
  } finally {
    isLoading.value = false
    router.push('/login')
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
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
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Create your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Join our library management system
        </p>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleSubmit">
        <div class="space-y-4">
          <div class="mt-1">
            <InputField
                label="Name"
                v-model="form.name"
                placeholder="Enter Name"
                :rules="[requiredValidator]"
              />
          </div>
  
          <div>
            <InputField
              label="Email"
              v-model="form.email"
              placeholder="Enter Email"
              :rules="[requiredValidator, emailValidator]"
            />
          </div>
  
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
  
          <div class="flex items-center">
            <input
              id="is_admin"
              v-model="form.is_admin"
              name="is_admin"
              type="checkbox"
              class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            />
            <label for="is_admin" class="ml-2 block text-sm text-gray-900">
              Register as administrator
            </label>
          </div>
        </div>
  
        <div v-if="error" class="text-center">
          <p class="text-red-500 text-sm">{{ error }}</p>
        </div>
  
        <div>
          <button
            type="submit"
            class="btn-primary w-full flex justify-center"
            :disabled="isLoading"
          >
            <svg
              v-if="isLoading"
              class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
              ></path>
            </svg>
            {{ isLoading ? 'Creating account...' : 'Create account' }}
          </button>
        </div>
  
        <div class="text-center">
          <button 
            type="button" 
            class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
            @click="() => router.push('/login')"
          >
            Already have an account? Sign in
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.input-field {
  @apply appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm;
}
</style>