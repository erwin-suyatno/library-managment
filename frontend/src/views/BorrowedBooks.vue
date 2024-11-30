<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useLoanBookStore } from '../stores/loadBook'
import Pagination from '../components/Pagination.vue'
import BorrowedCard from '../components/BorrowedCard.vue';
import Navbar from '../components/Navbar.vue'

const loanBookStore = useLoanBookStore()

const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = 8

// Snackbar state
const showSnackbar = ref(false)
const snackbarMessage = ref('')
const snackbarType = ref('success')

const filteredBooks = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return loanBookStore.loanBooks.filter(loanBook => 
    loanBook.book.title.toLowerCase().includes(query) || 
    loanBook.book.author.toLowerCase().includes(query)
  )
})

const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return filteredBooks.value.slice(start, end)
})

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  snackbarMessage.value = message
  snackbarType.value = type
  showSnackbar.value = true
  setTimeout(() => {
    showSnackbar.value = false
  }, 3000)
}

const returnBook = async (id: number) => {
  try {
    await loanBookStore.returnBook(id)
    await loanBookStore.fetchLoanBooks()
    await showNotification('Book returned successfully')
  } catch (error) {
    console.error('Error returning book:', error)
    await showNotification('Failed to return book', 'error')
  }
}

onMounted(() => {
  loanBookStore.fetchLoanBooks()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <Navbar class="sticky top-0 z-50" />
    <main class="container py-8">
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

      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Borrowed Books</h1>
        <div class="relative">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search books..."
            class="input pl-10"
          />
          <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
            🔍
          </span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
        <BorrowedCard
          v-for="loanBook in paginatedBooks"
          :key="loanBook.id"
          :borrowedBook="loanBook"
          @return-book="returnBook"
        />
        <Pagination
          v-if="filteredBooks.length > itemsPerPage"
          :total-items="filteredBooks.length"
          :items-per-page="itemsPerPage"
          v-model:current-page="currentPage"
        />
      </div>
    </main>
  </div>
</template>