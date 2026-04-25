<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('photos')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role'     => ['required', Rule::in(['admin', 'user'])],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'admin_create_user',
            'description' => "Admin menambahkan user baru: {$user->name} ({$user->email})",
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil ditambahkan.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', Rule::in(['admin', 'user'])],
            'password' => ['nullable', 'confirmed', Password::min(6)],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'admin_edit_user',
            'description' => "Admin mengubah data user: {$user->name}",
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil diperbarui.");
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Delete user's photos from storage
        foreach ($user->photos as $photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
        }

        $name = $user->name;
        $user->delete(); // cascades photos & activity_logs

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'admin_delete_user',
            'description' => "Admin menghapus user: {$name}",
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$name} berhasil dihapus.");
    }
}
