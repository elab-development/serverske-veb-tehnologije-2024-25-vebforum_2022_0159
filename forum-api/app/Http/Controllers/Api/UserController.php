<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Prikaz svih korisnika.
     * Samo admin.
     */
    public function index(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $users = User::select('id', 'name', 'username', 'email', 'role', 'created_at')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    /**
     * Promena uloge korisnika.
     * Samo admin.
     */
    public function updateRole(Request $request, User $user)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $data = $request->validate([
            'role' => 'required|in:user,moderator,admin',
        ]);

        $user->update([
            'role' => $data['role'],
        ]);

        return response()->json([
            'message' => 'User role updated successfully.',
            'user' => $user,
        ]);
    }

    /**
     * Brisanje korisnika.
     * Samo admin.
     */
    public function destroy(Request $request, User $user)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        // Admin ne može obrisati samog sebe
        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'You cannot delete your own account.'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.'
        ]);
    }
}