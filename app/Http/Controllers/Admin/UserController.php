<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->withCount('bookings')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return redirect()->route('admin.users.index')
            ->with('toast_success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Tidak dapat melihat data admin.');
        }

        $user->load(['bookings' => function ($query) {
            $query->with('room')->latest();
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Tidak dapat mengedit data admin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Tidak dapat mengedit data admin.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('toast_success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Tidak dapat menghapus admin.');
        }

        // Hapus semua booking user terlebih dahulu
        $user->bookings()->delete();
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('toast_success', 'User berhasil dihapus beserta semua booking-nya.');
    }

    public function resetPassword(Request $request, User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Tidak dapat reset password admin.');
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('toast_success', 'Password user berhasil direset.');
    }
}