<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    protected function handleFileUpload(Request $request, string $field, ?string $oldPath = null): ?string
    {
        if (!$request->hasFile($field) || !$request->file($field)->isValid()) {
            return $oldPath;
        }

        $path = $request->file($field)->store('uploads/news', 'public');

        return $path ? 'storage/' . $path : null;
    }

    protected function deleteFile(?string $path): void
    {
        if (!$path) {
            return;
        }

        $relativePath = preg_replace('#^storage/#', '', ltrim($path, '/'));

        if ($relativePath) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
