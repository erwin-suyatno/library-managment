import { defineStore } from 'pinia'
import axios from '../plugins/axios'

export const useLoanBookStore = defineStore('loanBooks', {
  state: () => ({
    loanBooks: [],
  }),
  getters: {
    getLoanBooks(): any {
      return this.loanBooks
    }
  },
  actions: {
    fetchLoanBooks() {
      return new Promise((resolve, reject) => {
        axios.get('/loans')
          .then((response) => {
            this.loanBooks = response.data.data
            
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    borrowBook(payload: any) {
      return new Promise((resolve, reject) => {
        axios.post('/loans/borrow', payload)
          .then((response) => {
            this.loanBooks.push(response.data.data)
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    returnBook(payload: any) {
      return new Promise((resolve, reject) => {
        axios.put(`/loans/${payload}/return`, payload)
          .then((response) => {
            let i = this.loanBooks.findIndex((loanBook: any) => loanBook.id === payload)
            this.loanBooks[i] = payload
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    }
  },
})