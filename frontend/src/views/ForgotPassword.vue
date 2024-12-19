<script setup lang="ts">
import { ref } from 'vue'
import { useUserStore } from '../stores/users'
import { requiredValidator } from '../utils/validator'
import InputField from '../components/InputField.vue'

const userStore = useUserStore()

const forgotEmail = ref('')
const error = ref('')
const changePassword = ref(false)

const checkEmail = async (email: string) => {
  try {
    await userStore.fetchCheckEmail(email)
    const checkEmail = await userStore.getCheckEmail
    
    if (checkEmail) {
      changePassword.value = true
    }
  } catch (err: any) {
    console.error('Email check error:', err)
    error.value = err.response?.data?.message || 'Email check failed'
  }
}

</script>

<template>
  <div v-if="!changePassword" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="card max-w-md w-full space-y-8 p-8">
      <div>
        <div class="text-center text-4xl mb-2">📚</div>
        <h2 class="mt-4 text-center text-3xl font-extrabold text-gray-900">
          Forgot Password
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          If you have forgotten your password, you can reset it here
        </p>
      </div>
  
      <div class="space-y-4">
        <div>
          <InputField
            label="Email"
            v-model="forgotEmail"
            placeholder="Enter Email"
            :rules="[requiredValidator]"
          />
        </div>
      </div>
      <div>
        <button class="btn-primary w-full" @click="checkEmail(forgotEmail)">
          Reset Password
        </button>
      </div>
    </div>
  
    <!-- Change Password -->
    <div v-if="changePassword" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
      <ChangePassword :email="forgotEmail" />
    </div>
  </div>
</template>