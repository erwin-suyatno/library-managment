<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Book::all();
            return response()->json([
                'data' => BookResource::collection($books),
                'message' => 'Books retrieved successfully',
                'errors' => null
            ], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'An error occurred while retrieving books',
                'errors' => ['server' => 'Internal server error']
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'isbn' => 'required|unique:books',
                'total_copies' => 'required|integer',
                'available_copies' => 'required|integer',
                'cover' => 'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'data' => null,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $data = $request->all();
    
            // Jika cover adalah file
            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $path = $file->store('books', 'public');
                $data['cover'] = '/storage/' . $path;
            }
            // Jika cover adalah URL, gunakan langsung
            else if (filter_var($request->cover, FILTER_VALIDATE_URL)) {
                $data['cover'] = $request->cover;
            }

            $book = Book::create($request->all());

            return response()->json([
                'data' => new BookResource($book),
                'message' => 'Book created successfully',
                'errors' => null
            ], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'An error occurred while creating the book',
                'errors' => ['server' => 'Internal server error']
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response([
            'book' => new BookResource($book),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'isbn' => 'required|unique:books',
            'total_copies' => 'required|integer',
            'available_copies' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => null,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('cover')) {
            // Delete old image if exists
            if ($book->cover) {
                $oldPath = str_replace('/storage/', '', $book->cover);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('cover');
            $path = $file->store('books', 'public');
            $data['cover'] = '/storage/' . $path;
        }

        $book->update($data);

        return response([
            'book' => new BookResource($book),
            'message' => 'Book updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response([
            'message' => 'Book deleted successfully'
        ], 200);
    }
}
