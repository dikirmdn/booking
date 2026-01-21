<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('bookings')->latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'floor' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'facilities' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'image.max' => 'Ukuran gambar terlalu besar. Silakan pilih gambar dengan ukuran maksimal 2 MB.',
            'image.mimes' => 'Format gambar tidak didukung. Silakan gunakan format JPEG, PNG, JPG, atau GIF.',
            'image.image' => 'File yang diupload harus berupa gambar.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/rooms'), $imageName);
            $validated['image'] = 'images/rooms/' . $imageName;
        }

        // fasilitas menjadi array
        if (!empty($validated['facilities'])) {
            $validated['facilities'] = array_map('trim', explode(',', $validated['facilities']));
        } else {
            $validated['facilities'] = null;
        }

        $validated['is_active'] = $request->has('is_active');

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Room $room)
    {
        $room->load('bookings.user');
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'floor' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'facilities' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'image.max' => 'Ukuran gambar terlalu besar. Silakan pilih gambar dengan ukuran maksimal 2 MB.',
            'image.mimes' => 'Format gambar tidak didukung. Silakan gunakan format JPEG, PNG, JPG, atau GIF.',
            'image.image' => 'File yang diupload harus berupa gambar.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($room->image && file_exists(public_path($room->image))) {
                unlink(public_path($room->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/rooms'), $imageName);
            $validated['image'] = 'images/rooms/' . $imageName;
        }

        // fasilitas ke array
        if (!empty($validated['facilities'])) {
            $validated['facilities'] = array_map('trim', explode(',', $validated['facilities']));
        } else {
            $validated['facilities'] = null;
        }

        $validated['is_active'] = $request->has('is_active');

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        // Delete image if exists
        if ($room->image && file_exists(public_path($room->image))) {
            unlink(public_path($room->image));
        }
        
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
