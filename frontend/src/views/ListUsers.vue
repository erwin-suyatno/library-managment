<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useUserStore } from '../stores/users'
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'
import LoadingScreen from '../components/LoadingScreen.vue'

const userStore = useUserStore()
const router = useRouter()

const users = ref([])
const isLoading = ref(false)

onMounted(async () => {
  try {
    await userStore.fetchUsers()
    users.value = userStore.getUsers
  } catch (error) {
    console.error('Error fetching users:', error)
  }
})

const handleUpdateClick = (user: any) => {
  router.push({
    name: 'edit-user',
    params: { id: user.id },
  })
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
                  <tr v-for="user in users" :key="user.id">
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
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a
                        href="#"
                        class="text-indigo-600 hover:text-indigo-900"
                        @click.prevent="handleUpdateClick(user)"
                      >
                        Edit
                      </a>
                      <a
                        href="#"
                        class="text-red-600 hover:text-red-900 ml-4"
                        @click.prevent="handleDeleteClick(user.id)"
                      >
                        Delete
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
