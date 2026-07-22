<?php

if (! function_exists('img_url')) {
    /**
     * Kembalikan URL gambar yang benar.
     * - Jika sudah URL absolute (https://res.cloudinary.com/...), kembalikan apa adanya.
     * - Jika path lokal (/storage/... atau /img/...), bungkus dengan asset().
     * - Jika null/kosong, kembalikan fallback.
     */
    function img_url(?string $url, ?string $fallback = null): string
    {
        if (empty($url)) {
            return $fallback ? asset($fallback) : '';
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return asset($url);
    }
}
