<script setup lang="ts">
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import { ref } from 'vue'

const auth = useAuthStore()
const router = useRouter()
const isMenuOpen = ref(false)

const user = JSON.parse(localStorage.getItem('user') || '{}')

const handleLogout = () => {
  auth.Logout()
  router.push('/')
}

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
</script>

<template>
  <nav class="bg-white shadow-sm border-b border-gray-100">
    <div class="container">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <router-link to="/books" class="flex items-center">
            <span class="text-2xl text-indigo-600">📚</span>
            <span class="ml-2 text-xl font-semibold text-gray-900">Library</span>
          </router-link>
          <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
            <router-link 
              to="/books" 
              class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
              active-class="text-indigo-600 bg-indigo-50"
            >
              Books
            </router-link>
            <router-link 
              v-if="user.is_admin === true"
              to="/borrowed" 
              class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
              active-class="text-indigo-600 bg-indigo-50"
            >
              Borrowed Books
            </router-link>
            <router-link 
              v-if="user.is_admin === true"
              to="/add-book" 
              class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
              active-class="text-indigo-600 bg-indigo-50"
            >
              Add Book
            </router-link>
          </div>
        </div>
        
        <!-- Mobile menu button -->
        <div class="flex items-center sm:hidden">
          <button 
            @click="toggleMenu"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
          >
            <span class="sr-only">Open main menu</span>
            <svg 
              class="h-6 w-6" 
              :class="{ 'hidden': isMenuOpen, 'block': !isMenuOpen }"
              stroke="currentColor" 
              fill="none" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg 
              class="h-6 w-6" 
              :class="{ 'block': isMenuOpen, 'hidden': !isMenuOpen }"
              stroke="currentColor" 
              fill="none" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="hidden sm:flex sm:items-center sm:space-x-4">
          <button 
            @click="handleLogout" 
            class="btn-secondary"
          >
            Logout
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div 
      class="sm:hidden"
      :class="{ 'block': isMenuOpen, 'hidden': !isMenuOpen }"
    >
      <div class="pt-2 pb-3 space-y-1">
        <router-link 
          to="/books" 
          class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
          active-class="text-indigo-600 bg-indigo-50"
        >
          Books
        </router-link>
        <router-link 
          to="/borrowed" 
          class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
          active-class="text-indigo-600 bg-indigo-50"
        >
          Borrowed Books
        </router-link>
        <button 
          @click="handleLogout" 
          class="block w-full text-left px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
        >
          Logout
        </button>
      </div>
    </div>
  </nav>
</template>