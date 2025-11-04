<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $post = Post::create($validatedData);

        return response()->json($post, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'published_at' => 'sometimes|nullable|date',
        ]);

        $post->update($validatedData);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        $post->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
