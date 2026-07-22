<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk integrasi Cloudinary. Ambil dari CLOUDINARY_URL di .env
    | Format: cloudinary://api_key:api_secret@cloud_name
    |
    */

    'url' => env('CLOUDINARY_URL'),

    /*
    | Folder default untuk menyimpan gambar di Cloudinary
    */
    'folder' => env('CLOUDINARY_FOLDER', 'project-gunung'),
];
