import { defineStore } from 'pinia'
import axios from '../plugins/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: '',
    activeUser: {},
  }),
  getters: {
    getToken(): any {
      return this.token
    },
    getActiveUser():any  {
      return this.activeUser
    },
  },
  actions: {
    Login(payload: any) {
      return new Promise((resolve, reject) => {
        axios
          .post('/auth/login', payload)
          .then((response: any) => {
            this.token = response.data.token
            this.activeUser = response.data.user
            localStorage.setItem('token', JSON.stringify(response.data.token))
            localStorage.setItem('user', JSON.stringify(response.data.user))
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    curentUser() {
      return new Promise((resolve, reject) => {
        axios
          .get('/auth/user')
          .then((response: any) => {
            this.token = response.data.token
            this.activeUser = response.data.user
            localStorage.setItem('token', JSON.stringify(response.data.token))
            localStorage.setItem('user', JSON.stringify(response.data.user))
            resolve(true)
          })
          .catch((error: any) => {
            console.error(error)
            reject(false)
          })
      })
    },
    Logout() {
      this.token = ''
      this.activeUser = {}
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    },
  },
})