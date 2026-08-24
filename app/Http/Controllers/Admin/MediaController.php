<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaRequest;
use App\Models\Media;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(): View
    {
        $mediaItems = Media::query()->latest()->paginate(30);

        return view('admin.media.index', compact('mediaItems'));
    }

    public function store(MediaRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $path = $file->store('media', 'public');

        Media::query()->create([
            'uploaded_by' => $request->user()->getKey(),
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name' => basename($path),
            'disk' => 'public',
            'path' => $path,
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize(),
            'alt_text' => $request->string('alt_text')->trim()->toString(),
        ]);

        return back()->with('success', 'Đã tải ảnh lên thư viện.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return back()->with('success', 'Đã xóa file khỏi thư viện.');
    }
}
