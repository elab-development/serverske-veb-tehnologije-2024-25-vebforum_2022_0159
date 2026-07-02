<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if ($request->user()->id !== $post->user_id && $request->user()->role !== 'moderator') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        if ($post->attachment) {
            return response()->json([
                'message' => 'This post already has an attachment.'
            ], 422);
        }

        $file = $request->file('file');
        $path = $file->store('attachments', 'public');

        $attachment = Attachment::create([
            'post_id' => $post->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json($attachment, 201);
    }

    public function destroy(Request $request, Attachment $attachment)
    {
        $post = $attachment->post;

        if ($request->user()->id !== $post->user_id && $request->user()->role !== 'moderator') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        Storage::disk('public')->delete($attachment->file_path);

        $attachment->delete();

        return response()->json(['message' => 'Attachment deleted successfully.']);
    }

    public function show(Post $post)
    {
        if (!$post->attachment) {
            return response()->json([
                'message' => 'Attachment not found.'
            ], 404);
        }

        return response()->json($post->attachment);
    }
}
