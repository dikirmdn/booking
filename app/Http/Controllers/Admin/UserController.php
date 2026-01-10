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
        $users = User::withCount('bookings')
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
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,admin'],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('toast_success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        // Admin bisa melihat semua user, termasuk admin lain
        $user->load(['bookings' => function ($query) {
            $query->with('room')->latest();
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Admin bisa mengedit semua user, termasuk admin lain
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Admin bisa mengupdate semua user, termasuk admin lain
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:user,admin'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('toast_success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('toast_error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus semua booking user terlebih dahulu
        $user->bookings()->delete();
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('toast_success', 'User berhasil dihapus beserta semua booking-nya.');
    }

    public function resetPassword(Request $request, User $user)
    {
        // Admin bisa reset password semua user, termasuk admin lain
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