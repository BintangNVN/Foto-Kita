<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPhotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('filename', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $photos = $query->paginate(16)->withQueryString();

        return view('admin.photos.index', compact('photos'));
    }

    public function destroy(Request $request, Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'admin_delete_photo',
            'description' => "Admin menghapus foto '{$photo->filename}' milik user #{$photo->user_id}",
            'ip_address'  => $request->ip(),
        ]);

        $photo->delete();

        return redirect()->route('admin.photos.index')
            ->with('success', 'Foto berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'photo_ids'   => ['required', 'array'],
            'photo_ids.*' => ['integer', 'exists:photos,id'],
        ]);

        $photos = Photo::whereIn('id', $request->photo_ids)->get();

        foreach ($photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'admin_bulk_delete_photo',
            'description' => 'Admin menghapus ' . count($request->photo_ids) . ' foto sekaligus.',
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('admin.photos.index')
            ->with('success', count($request->photo_ids) . ' foto berhasil dihapus.');
    }
}
