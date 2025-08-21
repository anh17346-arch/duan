<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImageUpload
{
    protected string $imageDisk = 'public';
    protected string $imagePath = 'images';

    /**
     * Store image and return path
     */
    protected function storeImage(UploadedFile $file, ?string $customPath = null): string
    {
        $path = $customPath ?: $this->imagePath;
        return $file->store($path, $this->imageDisk);
    }

    /**
     * Delete old image if exists
     */
    protected function deleteOldImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk($this->imageDisk)->exists($imagePath)) {
            Storage::disk($this->imageDisk)->delete($imagePath);
        }
    }

    /**
     * Get image URL
     */
    protected function getImageUrl(?string $imagePath, string $defaultImage = 'images/placeholder.png'): string
    {
        if ($imagePath && Storage::disk($this->imageDisk)->exists($imagePath)) {
            return Storage::url($imagePath);
        }
        
        return asset($defaultImage);
    }

    /**
     * Check if image exists
     */
    protected function imageExists(?string $imagePath): bool
    {
        return $imagePath && Storage::disk($this->imageDisk)->exists($imagePath);
    }

    /**
     * Get image size in bytes
     */
    protected function getImageSize(?string $imagePath): ?int
    {
        if ($this->imageExists($imagePath)) {
            return Storage::disk($this->imageDisk)->size($imagePath);
        }
        
        return null;
    }

    /**
     * Get image mime type
     */
    protected function getImageMimeType(?string $imagePath): ?string
    {
        if ($this->imageExists($imagePath)) {
            return Storage::disk($this->imageDisk)->mimeType($imagePath);
        }
        
        return null;
    }

    /**
     * Move image to different path
     */
    protected function moveImage(string $oldPath, string $newPath): bool
    {
        if ($this->imageExists($oldPath)) {
            $contents = Storage::disk($this->imageDisk)->get($oldPath);
            Storage::disk($this->imageDisk)->put($newPath, $contents);
            Storage::disk($this->imageDisk)->delete($oldPath);
            return true;
        }
        
        return false;
    }

    /**
     * Copy image to different path
     */
    protected function copyImage(string $oldPath, string $newPath): bool
    {
        if ($this->imageExists($oldPath)) {
            $contents = Storage::disk($this->imageDisk)->get($oldPath);
            Storage::disk($this->imageDisk)->put($newPath, $contents);
            return true;
        }
        
        return false;
    }
}
