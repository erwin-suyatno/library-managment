<script setup lang="ts">

interface BorrowedBook {
  id: number
  book: {
    title: string
    author: string
    cover: string
  }
  borrowed_at: string
  due_date: string
  returned_at: string
  fine_amount: string
  is_returned: boolean
  created_at: string
  updated_at: string
  user: {
    id: number
    name: string
    email: string
  }
}

defineProps<{
  borrowedBook: BorrowedBook
}>()

const getStatusClass = (status: string) => {
  switch (status) {
    case 'ongoing':
      return 'bg-blue-100 text-blue-800'
    case 'overdue':
      return 'bg-red-100 text-red-800'
    case 'returned':
      return 'bg-green-100 text-green-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

defineEmits<{
  (e: 'return-book', id: number): void
}>()
</script>

<template>
  <div class="card overflow-hidden">
    <img :src="borrowedBook.book.cover" :alt="borrowedBook.book.title" class="w-full h-48 object-cover" />
    <div class="p-4">
      <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ borrowedBook.book.title }}</h2>
      <p class="text-gray-600 text-sm mb-2">by {{ borrowedBook.book.author }}</p>
      <div class="flex justify-between items-center mb-2">
        <div>
          <p class="text-sm text-gray-500">Borrow Date</p>
          <p class="text-gray-900">{{ new Date(borrowedBook.borrowed_at).toLocaleDateString() }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Return Date</p>
          <p class="text-gray-900">{{ new Date(borrowedBook.due_date).toLocaleDateString() }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Borrower</p>
          <p class="text-gray-900">{{ borrowedBook.user.name }}</p>
          <p class="text-gray-600 text-sm">{{ borrowedBook.user.email }}</p>
        </div>
      </div>
      <div class="flex justify-between items-center mb-2">
        <span :class="getStatusClass(borrowedBook.is_returned ? 'returned' : borrowedBook.due_date < new Date().toISOString() ? 'overdue' : 'ongoing')" class="px-2 py-1 rounded-full text-xs font-medium">
          {{ borrowedBook.is_returned ? 'Returned' : 'Ongoing' }}
        </span>
        <button
          v-if="!borrowedBook.is_returned"
          @click="$emit('return-book', borrowedBook.id)"
          class="btn-primary text-sm"
        >
          Return Book
        </button>

      </div>
    </div>
  </div>
</template>