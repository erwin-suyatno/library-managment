# Library Management System API Documentation

## API Endpoints

### 1. Authentication API

#### Register User
- **URL**: `/api/auth/register`
- **Method**: `POST`
- **Request Body**:
```json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string",
    "is_admin": "boolean"
}

```
- **Response**:
```json
{
    "user": {
        "name": "string",
        "email": "string",
        "is_admin": "boolean",
        "updated_at": "date",
        "created_at": "date",
        "id": 1
    },
    "token": "token"
}
```

#### Login User
- **URL**: `/api/auth/login`
- **Method**: `POST`
- **Request Body**:
```json
{
    "email": "string",
    "password": "string"
}
```
- **Response**:
```json
{
    "user": {
        "id": 1,
        "name": "string",
        "email": "string",
        "is_admin": "boolean",
        "created_at": "date",
        "updated_at": "date"
    },
    "token": "token"
}
```

#### Logout User
- **URL**: `/api/auth/logout`
- **Method**: `POST`
- **Response**:
```json
{
    "message": "string"
}
```

### 2. Users API

#### List Users
- **URL**: `/api/users`
- **Method**: `GET`
- **Headers**: `Authorization: Bearer <token>`
- **Response**:
```json
{
    "users": [
        {
            "id": 1,
            "name": "string",
            "email": "string",
            "is_admin": "boolean",
            "created_at": "date",
            "updated_at": "date"
        }
    ]
}
```

#### Reset Password
- **URL**: `/api/users/reset-password`
- **Method**: `PUT`
- **Request Body**:
```json
{
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}
```
- **Response**:
```json
{
    "message": "string"
}
```

#### Check Email
- **URL**: `/api/users/check-email/{email}`
- **Method**: `GET`
- **Request Body**:
- **Response**:
```json
{
    "exists": Boolean
}
```

### 3. Books API

#### List Books
- **URL**: `/api/books`
- **Method**: `GET`
- **Headers**: `Authorization: Bearer <token>`
- **Response**:
```json
{
    "data": [
        {
            "id": 1,
            "title": "string",
            "author": "string",
            "description": "string",
            "isbn": "string",
            "published_year": 2024,
            "total_copies": 5,
            "available_copies": 3
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 10,
        "per_page": 10
    }
}
```

#### Get Book
- **URL**: `/api/books/{id}`
- **Method**: `GET`
- **Headers**: `Authorization: Bearer <token>`
- **Response**:
```json
{
    "id": 1,
    "title": "string",
    "author": "string",
    "description": "string",
    "isbn": "string",
    "published_year": 2024,
    "total_copies": 5,
    "available_copies": 3
}
```

#### Create Book
- **URL**: `/api/books`
- **Method**: `POST`
- **Headers**: `Authorization: Bearer <token>`
- **Request Body**:
```json
{
    "title": "string",
    "author": "string",
    "description": "string",
    "isbn": "string",
    "published_year": "integer",
    "total_copies": "integer",
    "available_copies": "integer"
}
```
- **Response**:
```json
{
    "book": {
        "id": 1,
        "title": "string",
        "author": "string",
        "description": "string",
        "isbn": "string",
        "published_year": 2024,
        "total_copies": 5,
        "available_copies": 3
    },
    "message": "string"
}
```

#### Update Book
- **URL**: `/api/books/{id}`
- **Method**: `PUT`
- **Headers**: `Authorization: Bearer <token>`
- **Request Body**:
```json
{
    "title": "string",
    "author": "string",
    "description": "string",
    "isbn": "string",
    "published_year": "integer",
    "total_copies": "integer",
    "available_copies": "integer"
}
```
- **Response**:
```json
{
    "book": {
        "id": 1,
        "title": "string",
        "author": "string",
        "description": "string",
        "isbn": "string",
        "published_year": 2024,
        "total_copies": 5,  
        "available_copies": 3
    },
    "message": "string"
}
```

#### Delete Book
- **URL**: `/api/books/{id}`
- **Method**: `DELETE`
- **Headers**: `Authorization: Bearer <token>`
- **Response**:
```json
{
    "message": "string"
}
```

### 4. Book Loans API

#### List Book Loans
- **URL**: `/api/loans`
- **Method**: `GET`
- **Headers**: `Authorization: Bearer <token>`
- **Response**:
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "book_id": 1,
            "loan_date": "date",
            "due_date": "date",
            "return_date": "date",
            "fine_amount": "decimal",
            "status": "string"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 10,
        "per_page": 10
    }
}
```

#### Borrow Book
- **URL**: `/api/loans/borrow`
- **Method**: `POST`
- **Headers**: `Authorization: Bearer <token>`
- **Request Body**:
```json
{
    "user_id": "integer",
    "book_id": "integer"
}
```
- **Response**:
```json
{
    "data": {
        "id": 1,
        "user": {
            "id": 1,
            "name": "string",
            "email": "string"
        },
        "book": {
            "id": 1,
            "title": "string",
            "author": "string"
        },
        "borrowed_at": "date",
        "due_date": "date",
        "returned_at": "date",
        "fine_amount": "decimal",
        "is_returned": "boolean",
        "created_at": "date",
        "updated_at": "date",
    }
}
```

#### Return Book
- **URL**: `/api/loans/{loan_id}/return`
- **Method**: `PUT`
- **Headers**: `Authorization: Bearer <token>`
- **Response**:
```json
{
    "data": {
        "id": 1,
        "returned_at": "2024-11-26T00:00:00.000000Z",
        "fine_amount": 0,
        "is_returned": true
    }
}
```
#### Error Response
- **Validation Error**:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field": [
            "Error message"
        ]
    }
}
```

- **Authentication Error**:
```json
{
    "message": "Unauthenticated."
}
```

- **Not Found Error**:
```json
{
    "message": "Resource not found."
}
```