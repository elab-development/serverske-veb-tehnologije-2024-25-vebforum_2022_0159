<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $query = Topic::with('user')->withCount('posts');

        // Pretraga po naslovu i opisu
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtriranje po autoru teme
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Dozvoljene kolone za sortiranje
        $allowedSortFields = ['title', 'created_at'];

        $sortBy = in_array($request->sort_by, $allowedSortFields)
            ? $request->sort_by
            : 'created_at';

        // Dozvoljeni smerovi sortiranja
        $sortDirection = $request->sort_dir === 'asc' ? 'asc' : 'desc';

        $topics = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($request->get('per_page', 10));

        return response()->json($topics);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $topic = Topic::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        return response()->json($topic, 201);
    }

    public function show(Topic $topic)
    {
        return response()->json(
            $topic->load(['user', 'posts.user'])->loadCount('posts')
        );
    }

    public function update(Request $request, Topic $topic)
    {
        if (
            $request->user()->id !== $topic->user_id &&
            !$request->user()->isModerator() &&
            !$request->user()->isAdmin()
        ) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $topic->update($data);

        return response()->json($topic);
    }

    public function destroy(Request $request, Topic $topic)
    {
        if (
            $request->user()->id !== $topic->user_id &&
            !$request->user()->isModerator() &&
            !$request->user()->isAdmin()
        ) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $topic->delete();

        return response()->json(['message' => 'Topic deleted successfully.']);
    }
}
