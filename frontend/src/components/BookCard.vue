<!-- src/components/BookCard.vue -->
<script setup lang="ts">
const user = JSON.parse(localStorage.getItem('user') || '{}')

interface Book {
  id: number
  title: string
  author: string
  available: boolean
  cover: string
  description: string
}

defineProps<{
  book: Book
}>()

defineEmits<{
  (e: 'delete-book', id: number): void
  (e: 'borrow-click', id: number): void
}>()
</script>

<template>
  <div class="bg-white shadow-md rounded-lg overflow-hidden transition-transform transform hover:scale-105">
    <img :src="book.cover" :alt="book.title" class="w-full h-48 object-cover" />
    <div class="p-4">
      <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ book.title }}</h2>
      <p class="text-gray-600 text-sm mb-2">by {{ book.author }}</p>
      <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ book.description }}</p>
      <div class="flex justify-between items-center">
        <span 
          :class="book.available_copies > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
          class="px-2 py-1 rounded-full text-xs font-medium"
        >
          {{ book.available_copies > 0 ? `Available: ${book.available_copies}` : 'Borrowed' }}
        </span>
        <div class="flex space-x-2">
          <button
            v-if="book.available_copies > 0"
            class="btn-primary text-sm"
            @click="$emit('borrow-click', book.id)"
          >
            Borrow
          </button>
          <button
            v-if="user.is_admin"
            class="w-10 h-10 rounded-full bg-red-500 hover:bg-red-600 flex items-center justify-center transition-colors"
            @click="$emit('delete-book', book.id)"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>