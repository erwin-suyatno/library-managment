<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import Register from '../components/Register.vue'

const username = ref('')
const password = ref('')
const error = ref('')
const showRegister = ref(false)

const authStore = useAuthStore()
const router = useRouter()

const handleLogin = async () => {
  error.value = ''  // Reset error message
  
  const payload = {
    email: username.value,
    password: password.value
  }
  
  try {
    const success: any = await authStore.Login(payload)
    if (success) {
      console.log('Login successful, navigating to /books')
      await router.push('/books')
    }
  } catch (err: any) {
    console.error('Login error:', err)
    error.value = err.response?.data?.message || 'Login failed'
  }
}
</script>

<template>
  <div v-if="!showRegister" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
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
            <label for="username" class="block text-sm font-medium text-gray-700">
              Username
            </label>
            <div class="mt-1">
              <input
                id="username"
                v-model="username"
                type="text"
                required
                class="input"
                placeholder="Enter your username"
              />
            </div>
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <div class="mt-1">
              <input
                id="password"
                v-model="password"
                type="password"
                required
                class="input"
                placeholder="Enter your password"
              />
            </div>
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <div class="text-sm">
              <a href="#" class="font-medium text-blue-600 hover:text-blue-500" @click.prevent="showRegister = true">
                Register
              </a>
            </div>
            <div class="text-sm">
              <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
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
  <div v-if="showRegister" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <Register @switch-to-login="showRegister = false" />
  </div>
</template>