# Library Management System Frontend

A modern web application for managing a library system built with Vue 3, TypeScript, and Tailwind CSS.

## 🚀 Features

- 📚 Browse and search books
- 👤 User authentication
- 📖 Book borrowing system
- 👨‍💼 Admin dashboard for managing borrowed books
- 🎨 Modern and responsive UI
- 🔍 Real-time search and filtering
- 📱 Mobile-friendly design

## 🛠️ Tech Stack

- Vue 3 with Composition API
- TypeScript
- Tailwind CSS
- Pinia for state management
- Vue Router for navigation

## 📋 Prerequisites

- Node.js (v14 or higher)
- npm or yarn

## 🔧 Installation

1. Clone the repository
```bash
git clone <repository-url>
cd library-management/frontend
```

2. Install dependencies
```bash
npm install
# or
yarn install
```

3. Create a `.env` file
```bash
VITE_API_URL=http://localhost:8000/api
```

4. Start the development server
```bash
npm run dev
# or
yarn dev
```

## 📁 Project Structure
```
frontend/
├── src/
│   ├── components/      # Reusable Vue components
│   ├── views/           # Page components
│   ├── stores/          # Pinia state management
│   ├── router/          # Vue Router configuration
│   ├── assets/          # Static assets
│   └── App.vue          # Root component
├── public/              # Public static assets
└── index.html          # Entry HTML file
```

## 🔐 Authentication
The system supports two types of users:
- Regular users: Can browse and borrow books
- Admin users: Full access to the system

## 📱 Components
- **BookCard**: Card component for displaying book information
- **BorrowBook**: Component for borrowing a book
- **BorrowedCard**: Card component for displaying borrowed book information
- **Pagination**: Component for handling pagination
- **Navbar**: Navigation bar with links to different pages
- **FileInput**: Component for uploading files
- **InputField**: Component for input fields
- **TextArea**: Component for text areas

## 📚 Pages
- **Login**: Login page for user authentication
- **BookList**: Page for displaying a list of books
- **BorrowForm**: Page for borrowing a book
- **BorrowedBooks**: Page for displaying a list of borrowed books
- **AddBook**: Page for adding a new book

## 🛠️ Utilities
- **formatDate**: Utility function for formatting dates
- **showNotification**: Utility function for showing notifications

## 📦 Dependencies
- axios: HTTP client for making API requests
- pinia: State management library
- vue: JavaScript framework
- vue-router: Routing library

## 📦 Dev Dependencies
- @tailwindcss/forms: Tailwind CSS forms plugin
- @tailwindcss/line-clamp: Tailwind CSS line clamp plugin
- @vitejs/plugin-vue: Vite plugin for Vue
- autoprefixer: PostCSS plugin for adding vendor prefixes
- postcss: CSS preprocessor
- tailwindcss: CSS framework
- typescript: TypeScript compiler
- vite: Frontend build tool

## 🔄 State Management
Uses Pinia for state management.
- Authentication state
- Book management
- Borrowing system
- users

## 🎨 Styling
- Utilizes Tailwind CSS for responsive design
- Custom colors and styles for a modern and visually appealing interface
- mobile-first approach

## 🔨 Scripts
```bash
# Build for production
npm run build

# Preview production build
npm run preview

# Type checking
npm run type-check

# Linting
npm run lint
```

## 📝 Environment Variables
- `VITE_API_URL`: API endpoint for making requests to the backend