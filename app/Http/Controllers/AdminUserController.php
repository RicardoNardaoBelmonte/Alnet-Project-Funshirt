<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('user_type', 'C');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('blocked', $request->status === 'blocked' ? 1 : 0);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function block(User $user): RedirectResponse
    {
        $user->update(['blocked' => true]);

        return redirect()->route('admin.users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "User <strong>{$user->name}</strong> has been blocked.");
    }

    public function unblock(User $user): RedirectResponse
    {
        $user->update(['blocked' => false]);

        return redirect()->route('admin.users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "User <strong>{$user->name}</strong> has been unblocked.");
    }
}
