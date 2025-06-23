<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'A bejegyzés nem található.'
            ], 404);
        }

        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'A bejegyzés nem található.'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'body' => 'sometimes|required'
        ]);

        $post->update($validated);

        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'A bejegyzés nem található.'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'A bejegyzés sikeresen törölve.'
        ], 200);
    }
}
