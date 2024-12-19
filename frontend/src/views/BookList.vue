<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import BookCard from '../components/BookCard.vue'
import Pagination from '../components/Pagination.vue'
import BorrowBook from '../components/BorrowBook.vue'
import { useLoanBookStore } from '../stores/loadBook'
import { useBookStore } from '../stores/books'
import Navbar from '../components/Navbar.vue'
import LoadingScreen from '../components/LoadingScreen.vue'
import NoData from '../components/NoData.vue'

const bookStore = useBookStore()
const loanBookStore = useLoanBookStore()
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = 8

// Snackbar state
const showSnackbar = ref(false)
const snackbarMessage = ref('')
const snackbarType = ref('success')

// Dialog state
const showBorrowDialog = ref(false)
const selectedBook = ref(null)
const isLoading = ref(false)

onMounted(async () => {
  localStorage.removeItem('idBookBorrow')
  try {
    isLoading.value = true
    await bookStore.fetchBooks()
  } catch (error) {
    console.error('Error fetching books:', error)
    showNotification('Failed to fetch books', 'error')
  } finally {
    isLoading.value = false
  }
})

const filteredBooks = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return bookStore.books.filter(book => 
    book.title.toLowerCase().includes(query) || 
    book.author.toLowerCase().includes(query)
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

const deleteBook = async (id: number) => {
  try {
    await bookStore.deleteBook(id)
    await bookStore.fetchBooks()
    showNotification('Book deleted successfully')
  } catch (error) {
    console.error('Error deleting book:', error)
    showNotification('Failed to delete book', 'error')
  }
}

const handleBorrowClick = (book: any) => {
  selectedBook.value = book
  showBorrowDialog.value = true
}

const handleBorrowBook = async (formData: any) => {
  if (!selectedBook.value) return

  const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user') || '{}') : {}

  try {
    await loanBookStore.borrowBook({
      user_id: user.id,
      book_id: selectedBook.value.id,
    })
    showNotification('Book borrowed successfully')
    showBorrowDialog.value = false
    return Promise.resolve()
  } catch (error) {
    console.error('Error borrowing book:', error)
    showNotification('Failed to borrow book', 'error')
    return Promise.reject(error)
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <LoadingScreen :isLoading="isLoading" />
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
        <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">
          Library Collection
        </h1>
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

      <div v-if="filteredBooks.length === 0">
        <NoData />
      </div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <BookCard 
          v-for="book in paginatedBooks" 
          :key="book.id" 
          :book="book"
          @delete-book="deleteBook(book.id)"
          @borrow-click="handleBorrowClick(book)"
        />
        <Pagination
          v-if="filteredBooks.length > itemsPerPage"
          :total-items="filteredBooks.length"
          :items-per-page="itemsPerPage"
          v-model:current-page="currentPage"
        />
      </div>
      <BorrowBook
        :show="showBorrowDialog"
        :book="selectedBook"
        @close="showBorrowDialog = false"
        @submit="handleBorrowBook"
      />
    </main>
  </div>
</template>