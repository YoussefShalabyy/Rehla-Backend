<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MediaStorageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(private readonly MediaStorageInterface $storage)
    {
    }

    /**
     * Generic image upload endpoint.
     * Uploads the file using the exact same storage interface as listings
     * and returns the public URL.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'max:' . config('media.max_file_size_kb', 5120)],
            'folder' => ['nullable', 'string', 'max:50'],
        ]);

        $folder = $request->input('folder', 'destinations');
        
        // Exact same method used in MediaService for listings
        $result = $this->storage->upload($request->file('file'), $folder);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'data'    => [
                'url' => $result['url'],
            ],
            'meta'    => null,
            'errors'  => null,
        ], 201);
    }
}
