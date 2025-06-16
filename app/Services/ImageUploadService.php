<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadService
{
    /**
     * Upload a single image
     */
    public function upload(UploadedFile $file, string $directory = 'products'): string
    {
        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Create directory if it doesn't exist
        $path = "public/{$directory}";
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        
        // Store the file
        $filePath = $file->storeAs($path, $filename);
        
        // Return the path relative to storage/app/public
        return str_replace('public/', '', $filePath);
    }

    /**
     * Upload multiple images
     */
    public function uploadMultiple(array $files, string $directory = 'products'): array
    {
        $uploadedFiles = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedFiles[] = $this->upload($file, $directory);
            }
        }
        
        return $uploadedFiles;
    }

    /**
     * Delete an image
     */
    public function delete(string $path): bool
    {
        $fullPath = "public/{$path}";
        
        if (Storage::exists($fullPath)) {
            return Storage::delete($fullPath);
        }
        
        return false;
    }

    /**
     * Get image URL
     */
    public function getUrl(string $path): string
    {
        return asset("storage/{$path}");
    }
}
