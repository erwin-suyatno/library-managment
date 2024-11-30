import { defineStore } from 'pinia'
import axios from '../plugins/axios'

export const useBookStore = defineStore('books', {
  state: () => ({
    books: [],
  }),
  getters: {
    getBooks(): any {
      return this.books
    }
  },
  actions: {
    fetchBooks() {
      return new Promise((resolve, reject) => {
        axios.get('/books')
          .then((response) => {
            this.books = response.data.data
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    createBook(payload: any) {
      return new Promise((resolve, reject) => {
        axios.post('/books', payload)
          .then((response) => {
            this.books.push(response.data.data)
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    updateBook(payload: any) {
      return new Promise((resolve, reject) => {
        axios.put(`/books/${payload.id}`, payload)
          .then((response) => {
            let i = this.books.findIndex((book: any) => book.id === payload.id)
            this.books[i] = payload
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    deleteBook(id: number) {
      return new Promise((resolve, reject) => {
        axios.delete(`/books/${id}`)
          .then((response) => {
            let i = this.books.findIndex((book: any) => book.id === id)
            this.books.splice(i, 1)
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    }
  },
})