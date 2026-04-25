<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function gallery()
    {
        $photos = Auth::user()->photos()->latest()->paginate(12);
        return view('gallery.index', compact('photos'));
    }

    public function showUpload()
    {
        return view('gallery.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'title'  => ['nullable', 'string', 'max:255'],
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048', // 2MB
            ],
        ], [
            'photos.required'      => 'Minimal 1 foto harus diunggah.',
            'photos.*.mimes'       => 'Format file harus JPG atau PNG.',
            'photos.*.max'         => 'Ukuran file maksimal 2MB.',
        ]);

        $uploaded = 0;

        foreach ($request->file('photos') as $file) {
            $filename  = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path      = $file->storeAs('photos/' . Auth::id(), $filename, 'public');

            Photo::create([
                'user_id'   => Auth::id(),
                'title'     => $request->title ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'filename'  => $file->getClientOriginalName(),
                'path'      => $path,
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            $uploaded++;
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'upload',
            'description' => "Mengunggah {$uploaded} foto baru.",
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('gallery')->with('success', "{$uploaded} foto berhasil diunggah!");
    }

    public function preview(Photo $photo)
    {
        // Ensure user can only see their own photos
        if ($photo->user_id !== Auth::id()) {
            abort(403);
        }

        return view('gallery.preview', compact('photo'));
    }

    public function download(Photo $photo)
    {
        if ($photo->user_id !== Auth::id()) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($photo->path)) {
            abort(404, 'File tidak ditemukan.');
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'download',
            'description' => "Mengunduh foto: {$photo->filename}",
            'ip_address'  => request()->ip(),
        ]);

        return Storage::disk('public')->download($photo->path, $photo->filename);
    }

    public function destroy(Request $request, Photo $photo)
    {
        if ($photo->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($photo->path);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'delete',
            'description' => "Menghapus foto: {$photo->filename}",
            'ip_address'  => $request->ip(),
        ]);

        $photo->delete();

        return redirect()->route('gallery')->with('success', 'Foto berhasil dihapus.');
    }
}
