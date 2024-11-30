# Components Documentation

## Core Components

### BookCard
- Purpose: Displays individual book information
- Props:
  - book: Book object containing title, author, etc.
  - onBorrow: Function to handle book borrowing

### BorrowBook
- Purpose: Handles the book borrowing process
- Props:
  - bookId: ID of the book to borrow
  - onSuccess: Callback after successful borrowing

### BorrowedCard
- Purpose: Displays borrowed book information
- Props:
  - borrowedBook: Object containing borrowed book details
  - onReturn: Function to handle book return

### Navbar
- Purpose: Main navigation component
- Features:
  - Responsive menu
  - Authentication status
  - Admin/User specific links

### Pagination
- Purpose: Handles page navigation
- Props:
  - currentPage: Current active page
  - totalPages: Total number of pages
  - onPageChange: Page change handler

### Register
- Purpose: User registration form component
- Features:
  - Input validation
  - User role selection
  - Form submission handling

## Form Components

### FileInput
- Purpose: Custom file upload component
- Features:
  - Drag and drop support
  - File preview
  - Validation

### InputField
- Purpose: Reusable input component
- Props:
  - label: Input label
  - type: Input type (text, number, etc.)
  - validation: Validation rules

### TextArea
- Purpose: Reusable textarea component
- Props:
  - label: Textarea label
  - rows: Number of visible rows
  - validation: Validation rules
  - placeholder: Placeholder text