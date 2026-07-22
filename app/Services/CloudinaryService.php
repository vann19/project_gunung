<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

use Intervention\Image\Laravel\Facades\Image;

class CloudinaryService
{
    protected Cloudinary $cloudinary;
    protected string $folder;

    public function __construct()
    {
        Configuration::instance(config('cloudinary.url'));
        $this->cloudinary = new Cloudinary();
        $this->folder = config('cloudinary.folder', 'project-gunung');
    }

    /**
     * Upload satu file gambar ke Cloudinary.
     * Mengembalikan URL secure dari Cloudinary.
     */
    public function upload(UploadedFile $file, string $subfolder = ''): string
    {
        $folder = $subfolder
            ? $this->folder . '/' . trim($subfolder, '/')
            : $this->folder;

        $publicId = Str::random(40);
        $filePath = $file->getRealPath();

        // Jika ukuran file > 5MB, kompres otomatis agar tidak melebihi batas 10MB Cloudinary
        if ($file->getSize() > 5 * 1024 * 1024) {
            try {
                $tempPath = sys_get_temp_dir() . '/' . $publicId . '.jpg';
                $img = Image::read($file);
                $img->scaleDown(width: 1920, height: 1920);
                $img->toJpeg(80)->save($tempPath);
                $filePath = $tempPath;
            } catch (\Throwable $e) {
                // Fallback ke file asli jika kompresi gagal
            }
        }

        $result = $this->cloudinary->uploadApi()->upload(
            $filePath,
            [
                'folder'          => $folder,
                'public_id'       => $publicId,
                'resource_type'   => 'image',
                'transformation'  => [
                    ['width' => 1200, 'height' => 1200, 'crop' => 'limit', 'quality' => 'auto', 'fetch_format' => 'auto'],
                ],
                'overwrite'       => true,
            ]
        );

        if (isset($tempPath) && file_exists($tempPath)) {
            @unlink($tempPath);
        }

        return $result['secure_url'];
    }

    /**
     * Upload beberapa file gambar sekaligus.
     * Mengembalikan array URL.
     */
    public function uploadMultiple(array $files, string $subfolder = ''): array
    {
        $urls = [];
        foreach ($files as $file) {
            $urls[] = $this->upload($file, $subfolder);
        }
        return $urls;
    }

    /**
     * Hapus gambar dari Cloudinary berdasarkan URL-nya.
     * URL format: https://res.cloudinary.com/{cloud}/{type}/{resource_type}/{delivery}/{version}/{public_id}.{ext}
     */
    public function delete(string $url): bool
    {
        try {
            $publicId = $this->extractPublicId($url);
            if (!$publicId) {
                return false;
            }
            $this->cloudinary->uploadApi()->destroy($publicId, ['resource_type' => 'image']);
            return true;
        } catch (\Throwable $e) {
            // Log error tapi jangan throw - gambar yang gagal dihapus tidak critical
            \Illuminate\Support\Facades\Log::warning('Cloudinary delete failed: ' . $e->getMessage(), ['url' => $url]);
            return false;
        }
    }

    /**
     * Hapus beberapa gambar dari Cloudinary.
     */
    public function deleteMultiple(array $urls): void
    {
        foreach ($urls as $url) {
            if (!empty($url)) {
                $this->delete($url);
            }
        }
    }

    /**
     * Cek apakah sebuah URL adalah URL Cloudinary.
     */
    public function isCloudinaryUrl(string $url): bool
    {
        return str_contains($url, 'res.cloudinary.com');
    }

    /**
     * Ekstrak public_id dari Cloudinary URL.
     * Contoh URL: https://res.cloudinary.com/cloud_name/image/upload/v123/folder/filename.jpg
     */
    protected function extractPublicId(string $url): ?string
    {
        // Cari pola /upload/ atau /authenticated/ dalam URL
        if (preg_match('#/(?:upload|authenticated)/(?:v\d+/)?(.+?)(?:\.[a-zA-Z]+)?$#', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
