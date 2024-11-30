
<script setup lang="ts">
import { onMounted, ref } from 'vue'
import InputField from './InputField.vue'
import { requiredValidator, emailValidator } from '../utils/validator'

interface Book {
  id: number
  title: string
  author: string
  cover: string
  description: string
  available_copies: number
}

defineProps<{
  show: boolean
  book: Book | null
}>()

const emit = defineEmits(['close', 'submit'])

const form = ref({
  user_id: null,
  book_id: null,
  name: '',
  email: '',
})

const loading = ref(false)
const error = ref('')

// Snackbar state
const showSnackbar = ref(false)
const snackbarMessage = ref('')
const snackbarType = ref('success')

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  snackbarMessage.value = message
  snackbarType.value = type
  showSnackbar.value = true
  setTimeout(() => {
    showSnackbar.value = false
  }, 3000)
}

const handleSubmit = async () => {
  try {
    loading.value = true
    await emit('submit', form.value)
    showNotification('Book borrowed successfully!')
    form.value = {
      user_id: null,
      book_id: null,
      name: '',
      email: '',
    }
    emit('close')
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Failed to borrow book. Please try again.'
    showNotification(error.value, 'error')
  } finally {
    loading.value = false
  }
}

const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user') || '{}') : {}
onMounted(() => {
  if (user.is_admin) {
    form.value.name = user.name
    form.value.email = user.email
  }
})
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="emit('close')"></div>

    <!-- Dialog -->
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
        <!-- Snackbar -->
        <div
          v-if="showSnackbar"
          :class="[
            'fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300',
            snackbarType === 'success' ? 'bg-green-500' : 'bg-red-500'
          ]"
        >
          <p class="text-white">{{ snackbarMessage }}</p>
        </div>

        <!-- Close button -->
        <div class="absolute right-0 top-0 pr-4 pt-4">
          <button
            type="button"
            class="rounded-md bg-white text-gray-400 hover:text-gray-500"
            @click="emit('close')"
          >
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div v-if="book" class="card mb-4">
          <div class="md:flex">
            <div class="md:w-1/3">
              <img :src="book.cover" :alt="book.title" class="w-full h-full object-cover" />
            </div>
            <div class="p-6 md:w-2/3">
              <h1 class="text-2xl font-bold text-gray-900 mb-2">Borrow Book</h1>
              <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900">{{ book.title }}</h2>
                <p class="text-gray-600">by {{ book.author }}</p>
                <p class="text-gray-500 mt-2">{{ book.description }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
            <div class="mt-4">
              <form @submit.prevent="handleSubmit" class="space-y-4">
                <InputField
                  label="Name"
                  v-model="form.name"
                  placeholder="Enter your name"
                  :rules="[requiredValidator]"
                />

                <InputField
                  label="Email"
                  v-model="form.email"
                  placeholder="Enter your email"
                  :rules="[requiredValidator, emailValidator]"
                />

                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                  <button
                    type="submit"
                    class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto"
                    :disabled="loading"
                  >
                    {{ loading ? 'Processing...' : 'Borrow' }}
                  </button>
                  <button
                    type="button"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                    @click="emit('close')"
                  >
                    Cancel
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>