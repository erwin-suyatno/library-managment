# Code Standards & Conventions

## 1. PHP Coding Standards

### 1.1 PSR Standards
- Follow PSR-1: Basic Coding Standard
- Follow PSR-12: Extended Coding Style
- Follow PSR-4: Autoloading Standard

### 1.2 Naming Conventions
- **Classes**: PascalCase
  ```php
  class BookController
  ```
- **Methods**: camelCase
  ```php
  public function createBook()
  ```
- **Variables**: camelCase
  ```php
  $totalBooks = 0;
  ```
- **Constants**: UPPER_CASE
  ```php
  const API_BASE_URL = 'https://example.com/api';
  ```
### 1.3 File Structure
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── AuthController.php
│   │       ├── BookController.php
│   │       └── BookLoanController.php
│   ├── Resources/
│   │   ├── BookResource.php
│   │   └── BookLoanResource.php
│   └── Requests/
│       └── BookRequest.php
├── Models/
│   ├── User.php
│   ├── Book.php
│   └── BookLoan.php

### 1.4 Controller Standards
- **Single responsibility principle**: Each controller should perform a single task and have a single purpose.
- **Thin controllers, fat models**: Controllers should be thin and focus on handling user input and output, while models should be responsible for storing and retrieving data from the database.
- **Use form request for validation**: Use form requests to validate user input before saving to the database.
- **Use API resources for response transformation**: Use API resources to transform data before sending it to the client.
```php
class BookController extends Controller
{
    public function createBook(BookRequest $request)
    {
        $book = Book::create($request->all());
        return new BookResource($book);
    }
}
```

### 1.4 Model Standards
- **Defined relationships**: Define relationships between models using Eloquent relationships.
- **Use propper type casting**: Use type casting to convert data from the database to the correct data type.
- **Define fillable of guarded properties**: Define fillable and guarded properties to prevent mass assignment attacks.
- **Use model observers when needed**: Use model observers when needed to perform actions before or after model events.
```php
class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn'
    ];

    protected $casts = [
        'published_year' => 'integer',
        'is_available' => 'boolean'
    ];
}
```

## 2. API Standards

### 2.1 Response Format
```php
return response()->json([
    'data' => $data,
    'message' => $message,
    'errors' => $errors
], $statusCode);
```

### 2.2 HTTP Status Codes
- 200: OK
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Internal Server Error

### 2.3 Validation
- Use Form Requests for complex validation
- Return consistent error messages
```php
class BookRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books'
        ];
    }
}
```

## 3. Database Standards

### 3.1 Migration Standards
- Use proper column types
- Add foreign key constraints
- Use indexes for frequently queried columns
```php
public function up()
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('author');
        $table->string('isbn')->unique();
        $table->timestamps();
        $table->index(['title', 'author']);
    });
}
```

### 3.2 Relationship Naming
- Use meaningful relationship names
- Follow Laravel conventions
```php
// User Model
public function loans()
{
    return $this->hasMany(BookLoan::class);
}

// Book Model
public function loans()
{
    return $this->hasMany(BookLoan::class);
}
```

## Security Standards

### 4.1 Authentication
- Use Sanctum for API authentication
- Always validate user permissions
- Never expose sensitive data

### 4.2 Authorization
- Validate all input data
- Sanitize output data
- Use prepared statements (Laravel handles this)

### 4.3 Error Handling
- Never expose internal errors to users
- Log all critical errors
- Use try-catch blocks for error handling
```php
try {
    // code
} catch (\Exception $e) {
    \Log::error($e->getMessage());
    return response()->json(['message' => 'An error occurred'], 500);
}
```