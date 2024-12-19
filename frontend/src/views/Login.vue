<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import { requiredValidator, emailValidator } from '../utils/validator'
import InputField from '../components/InputField.vue'
import LoadingScreen from '../components/LoadingScreen.vue'

const username = ref('')
const password = ref('')
const error = ref('')
const showRegister = ref(false)
const isLoading = ref(false)

const authStore = useAuthStore()
const router = useRouter()

const handleLogin = async () => {
  error.value = ''  // Reset error message
  isLoading.value = true;

  const payload = {
    email: username.value,
    password: password.value
  }
  try {
    await authStore.Login(payload)
  } catch (err: any) {
    console.error('Login error:', err)
    error.value = err.response?.data?.message || 'Login failed'
  } finally {
    isLoading.value = false
    await router.push('/books')
  }
}
</script>

<template>
  <div v-if="!showRegister" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <LoadingScreen :isLoading="isLoading" />
    <div class="card max-w-md w-full space-y-8 p-8">
      <div>
        <div class="text-center text-4xl mb-2">📚</div>
        <h2 class="mt-4 text-center text-3xl font-extrabold text-gray-900">
          Library Login
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Welcome back! Please sign in to your account
        </p>
      </div>
      <form @submit.prevent="handleLogin" class="mt-8 space-y-6">
        <div class="space-y-4">
          <div>
            <InputField
              label="Email"
              v-model="username"
              placeholder="Enter Email"
              :rules="[requiredValidator, emailValidator]"
            />
          </div>
          <div>
            <InputField
              label="Password"
              v-model="password"
              type="password"
              placeholder="Enter Password"
              :rules="[requiredValidator]"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <div class="text-sm">
              <a href="/register" class="font-medium text-blue-600 hover:text-blue-500">
                Register
              </a>
            </div>
            <div class="text-sm">
              <a href="/forgot-password" class="font-medium text-blue-600 hover:text-blue-500">
                Forgot your password?
              </a>
            </div>
          </div>
        </div>
        <div>
          <p v-if="error" class="text-red-500 text-sm mb-4 text-center">{{ error }}</p>
          <button type="submit" class="btn-primary w-full flex justify-center">
            Sign in
          </button>
        </div>
      </form>
    </div>
  </div>
</template>