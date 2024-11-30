import { defineStore } from 'pinia'
import axios from '../plugins/axios'

export const useUserStore = defineStore('users', {
  state: () => ({
    users: [],
    activeUser: {},
  }),
  getters: {
    getUser(): any {
      return this.users
    },
    getActiveUser():any  {
      return this.activeUser
    },
  },
  actions: {
    fetchUsers() {
      return new Promise((resolve, reject) => {
        axios
          .get('/auth/users')
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
  },
})