# State Management

## Pinia Stores

### Authentication Store (auth.ts)
- User authentication state
- Login/Logout actions
- User role management
- Features:
  - Token management
  - Authentication status tracking
  - Role-based access control

### Book Store (books.ts)
- Book list management
- Book filtering and search
- Book CRUD operations
- Features:
  - Fetch all books
  - Add new book
  - Update book details
  - Delete book
  - Search functionality

### Loan Store (loadBook.ts)
- Borrowed books management
- Borrowing process
- Return book handling
- Features:
  - Borrow book
  - Return book
  - Track borrowed books
  - Borrowing history

### Users Store (users.ts)
- User management
- Features:
  - User registration
  - User profile management
  - User list (admin only)
  - User role management

## Best Practices
- Use composition API with setup script
- Implement proper type definitions
- Handle loading and error states
- State persistence where needed
- Action error handling
- Reactive state updates