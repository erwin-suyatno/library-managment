import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import BookList from '../views/BookList.vue'
import BorrowedBooks from '../views/BorrowedBooks.vue'
import AddBook from '../views/CreateBook.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { requiresAuth: false }
    },
    {
      path: '/books',
      name: 'books',
      component: BookList,
      meta: { requiresAuth: true }
    },
    {
      path: '/borrowed',
      name: 'borrowed',
      component: BorrowedBooks,
      meta: { requiresAuth: true }
    },
    {
      path: '/add-book',
      name: 'add-book',
      component: AddBook,
      meta: { requiresAuth: true }
    },
  ]
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  
  if (to.meta.requiresAuth && !token) {
    // Redirect to login if trying to access protected route without token
    next({ name: 'login' })
  } else if (to.name === 'login' && token) {
    // Redirect to books if trying to access login while authenticated
    next({ name: 'books' })
  } else {
    next()
  }
})

export default router