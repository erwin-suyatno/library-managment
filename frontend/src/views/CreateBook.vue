<script setup lang="ts">
import { ref } from 'vue';
import InputField from '../components/InputField.vue';
import TextArea from '../components/TextArea.vue';
import FileInput from '../components/FileInput.vue';
import { useRouter } from 'vue-router'
import { useBookStore } from '../stores/books'
import Navbar from '../components/Navbar.vue';


const router = useRouter()
const bookStore = useBookStore()

interface BookFormData {
    title: string;
    author: string;
    description: string;
    isbn: string;
    totalCopies: number;
    availableCopies: number;
    cover: File | null;
};

const formData = ref<BookFormData>({
  title: '',
  author: '',
  description: '',
  isbn: '',
  totalCopies: 0,
  availableCopies: 0,
  cover: null
});

const loading = ref(false)
const error = ref('')

const onSubmit = async () => {
  try {
    loading.value = true
    
    // Transform formData to match API expectations
    const bookData = {
      title: formData.value.title,
      author: formData.value.author,
      description: formData.value.description,
      isbn: formData.value.isbn,
      total_copies: formData.value.totalCopies,
      available_copies: formData.value.availableCopies,
      cover: '' // Will be updated if there's a file
    }

    // Handle file upload if exists
    if (formData.value.cover) {
      const formDataFile = new FormData()
      formDataFile.append('cover', formData.value.cover)
      // You might want to upload the file first and get the URL
      // For now, we'll just use a placeholder
      bookData.cover = URL.createObjectURL(formData.value.cover)
    }

    await bookStore.createBook(bookData)
    router.push('/books')
    // console.log(bookData);
    
  } catch (err: any) {
    error.value = err.message || 'Failed to create book'
  } finally {
    loading.value = false
  }
};
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <Navbar class="sticky top-0 z-50" />
    <main class="container py-8">
      <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
          <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Create New Book</h2>
            <p class="text-blue-100 mt-1">Add a new book to the library collection</p>
          </div>
          
          <form @submit.prevent="onSubmit" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <InputField
                label="Title"
                v-model="formData.title"
                placeholder="Enter book title"
              />
      
              <InputField
                label="Author"
                v-model="formData.author"
                placeholder="Enter author name"
              />
            </div>
      
            <TextArea
              label="Description"
              v-model="formData.description"
              placeholder="Enter book description"
            />
      
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <InputField
                label="ISBN"
                v-model="formData.isbn"
                placeholder="Enter ISBN"
              />
      
              <FileInput
                label="Cover Image"
                v-model="formData.cover"
              />
            </div>
      
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <InputField
                label="Total Copies"
                type="number"
                v-model="formData.totalCopies"
              />
      
              <InputField
                label="Available Copies"
                type="number"
                v-model="formData.availableCopies"
              />
            </div>
      
            <div class="pt-4">
              <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg"
              >
                Create Book
              </button>
            </div>
          </form>
        </div>
    </main>
  </div>
</template>