import { defineStore } from 'pinia'
import axios from '../plugins/axios'

export const useUserStore = defineStore('users', {
  state: () => ({
    users: [],
    user: null,
    checkEmail: false,
    activeUser: {},
  }),
  getters: {
    getUsers(): any {
      return this.users
    },
    getActiveUser():any  {
      return this.activeUser
    },
    getUser():any  {
      return this.user
    },
    getCheckEmail():any  {
      return this.checkEmail
    },
  },
  actions: {
    fetchUsers() {
      return new Promise((resolve, reject) => {
        axios
          .get('/users/')
          .then((response: any) => {
            this.users = response.data.users
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    Register(payload: any) {
      return new Promise((resolve, reject) => {
        axios
          .post('/auth/register', payload)
          .then((response: any) => {
            this.users.push(response.data.user)
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    fetchUserById(id: any) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/users/${id}`)
          .then((response: any) => {
            this.user = response.data.user
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    fetchCheckEmail(email: any) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/users/check-email/${email}`)
          .then((response: any) => {
            this.checkEmail = response.data.exists
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    fetchUserByEmail(email: any) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/users/email/${email}`)
          .then((response: any) => {
            this.user = response.data.user
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    updateUser(payload: any) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/users/${payload.id}`, payload)
          .then((response: any) => {
            this.user = response.data.user
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    resetPassword(payload: any) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/users/reset-password`, payload)
          .then((response: any) => {
            this.user = response.data.user
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    deleteUser(id: any) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/users/${id}`)
          .then((response: any) => {
            this.user = response.data.user
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
  },
})