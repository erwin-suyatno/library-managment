<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useUserStore } from '../stores/users'
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'
import LoadingScreen from '../components/LoadingScreen.vue'
import EditUser from '../components/EditUser.vue'

const userStore = useUserStore()
const router = useRouter()

const users = ref([])
const isLoading = ref(false)
const currentPage = ref(1)
const perPage = 10
const showEditModal = ref(false)
const selectedUser = ref(null)

onMounted(async () => {
  try {
    isLoading.value = true
    await userStore.fetchUsers()
    users.value = userStore.getUsers
  } catch (error) {
    console.error('Error fetching users:', error)
  } finally {
    isLoading.value = false
  }
})

const handleUpdateClick = (user: any) => {
  showEditModal.value = true
  selectedUser.value = user
}

const updateUser = async (updatedUser: any) => {
  try {
    isLoading.value = true
    showEditModal.value = false
    await userStore.updateUser(updatedUser)
  } catch (error) {
    console.error('Error updating user:', error)
  } finally {
    isLoading.value = false
  }
}

const handleDeleteClick = async (userId: number) => {
  try {
    isLoading.value = true
    await userStore.deleteUser(userId)    
    users.value = users.value.filter((user: any) => user.id !== userId)
  } catch (error) {
    console.error('Error deleting user:', error)
  } finally {
    isLoading.value = false
  }
}
</script>
<template>
  <div class="min-h-screen bg-gray-50">
    <LoadingScreen :isLoading="isLoading" />
    <Navbar class="sticky top-0 z-50" />
    <main class="container py-8">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">
          List of Users
        </h1>
      </div>
      <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-purple-100">
                  <tr>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/3"
                    >
                      Name
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/3"
                    >
                      Email
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/3"
                    >
                      Role
                    </th>
                    <th 
                      scope="col" 
                      class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/3"
                    >
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-gray-50 divide-y divide-gray-200">
                  <tr v-for="user in users.slice((currentPage - 1) * perPage, currentPage * perPage)" :key="user.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">
                        {{ user.name }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">
                        {{ user.email }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                      >
                        {{ user.is_admin ? 'Admin' : 'User' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center">
                      <a
                        href="#"
                        class="text-indigo-600 hover:text-indigo-900 mr-2"
                        @click.prevent="handleUpdateClick(user)"
                      >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                      </svg>
                      </a>
                      <a
                        href="#"
                        class="text-red-600 hover:text-red-900"
                        @click.prevent="handleDeleteClick(user.id)"
                      >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                      </svg>

                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="flex flex-row mt-6 justify-center">
                <button
                  class="py-2 px-4 text-sm font-medium text-white bg-purple-600 rounded-l-lg hover:bg-purple-300"
                  :disabled="currentPage === 1"
                  @click="currentPage = currentPage - 1"
                >
                  Previous
                </button>
                <div class="px-4 py-2 text-sm font-medium text-gray-700">
                  Page {{ currentPage }} of {{ Math.ceil(users.length / perPage) }}
                </div>
                <button
                  class="py-2 px-4 text-sm font-medium text-white bg-purple-600 rounded-r-lg hover:bg-purple-300"
                  :disabled="currentPage >= Math.ceil(users.length / perPage)"
                  @click="currentPage = currentPage + 1"
                >
                  Next
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <EditUser 
      v-if="showEditModal" 
      :user="selectedUser" 
      @back="showEditModal = false" 
      @update-user="updateUser($event)"/>
  </div>
</template>
