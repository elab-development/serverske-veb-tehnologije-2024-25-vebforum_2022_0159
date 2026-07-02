<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    /**
     * Prikaz svih postova za jednu temu.
     */
    public function index(Topic $topic)
    {
        $posts = $topic->posts()
            ->with(['user', 'attachment'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(10);

        return response()->json($posts);
    }

    /**
     * Kreiranje novog posta u temi.
     */
    public function store(Request $request, Topic $topic)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        //API

        $response = Http::get('https://www.purgomalum.com/service/containsprofanity', [
            'text' => $data['content'],
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Profanity check service is unavailable.'
            ], 503);
        }

        if ($response->body() === 'true') {
            return response()->json([
                'message' => 'Content contains inappropriate language.'
            ], 422);
        }

        $post = Post::create([
            'topic_id' => $topic->id,
            'user_id' => $request->user()->id,
            'content' => $data['content'],
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json(
            $post->load(['user', 'topic', 'comments.user', 'attachment'])
                ->loadCount(['likes', 'comments'])
        );
    }

    public function update(Request $request, Post $post)
    {
        if (
            $request->user()->id !== $post->user_id &&
            !$request->user()->isModerator() &&
            !$request->user()->isAdmin()
        ) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $post->update($data);

        return response()->json($post);
    }

    public function destroy(Request $request, Post $post)
    {
        if (
            $request->user()->id !== $post->user_id &&
            !$request->user()->isModerator() &&
            !$request->user()->isAdmin()
        ) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
