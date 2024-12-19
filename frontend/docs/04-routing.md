# Routing Documentation

## Route Structure
- /: Home page (redirects to /books)
- /login: User authentication
- /books: Book listing
- /borrowed: Borrowed books (Admin only)
- /create-book: Create new book (Admin only)
- /borrow-form: Book borrowing form
- /register: User registration
- /forgot-password: Password reset
- /users: User management (Admin only)

## Views
### Login.vue
- Path: /login
- Features:
  - User authentication form
  - Error handling
  - Redirect after login

### Register.vue
- Path: /register
- Features:
  - User registration form
  - Input validation
  - Redirect after successful registration

### ForgotPassword.vue
- Path: /forgot-password
- Features:
  - Password reset request form
  - Input validation
  - Notification on success or failure

### ListUsers.vue
- Path: /users
- Features:
  - Display all users
  - Admin management capabilities

### BookList.vue
- Path: /books
- Features:
  - Display all books
  - Search and filter
  - Pagination
  - Borrow functionality

### BorrowedBooks.vue
- Path: /borrowed
- Features:
  - List all borrowed books
  - Return book functionality
  - Admin only access

### CreateBook.vue
- Path: /create-book
- Features:
  - Book creation form
  - Image upload
  - Admin only access

### BorrowForm.vue
- Path: /borrow-form
- Features:
  - Book borrowing form
  - Borrowing confirmation
  - User validation

## Route Guards
- Authentication check
- Admin role verification
- Redirect handling
- Unauthorized access prevention

## Navigation
- Programmatic navigation using router.push()
- Route parameters handling
- Query parameters for search and filters
- Navigation guards for protected routes

## Best Practices
- Lazy loading for better performance
- Proper error handling
- Consistent naming conventions
- Clear route organization