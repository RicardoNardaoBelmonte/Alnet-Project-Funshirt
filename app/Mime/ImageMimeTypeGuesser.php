<?php

namespace App\Mime;

use Symfony\Component\Mime\MimeTypeGuesserInterface;

/**
 * Guesses image MIME types from magic bytes, avoiding a fileinfo dependency.
 */
class ImageMimeTypeGuesser implements MimeTypeGuesserInterface
{
    public function isGuesserSupported(): bool
    {
        return true;
    }

    public function guessMimeType(string $path): ?string
    {
        $handle = @fopen($path, 'rb');

        if ($handle === false) {
            return null;
        }

        $bytes = fread($handle, 12);
        fclose($handle);

        if ($bytes === false || strlen($bytes) < 4) {
            return null;
        }

        // JPEG: FF D8 FF
        if (str_starts_with($bytes, "\xFF\xD8\xFF")) {
            return 'image/jpeg';
        }

        // PNG: 89 50 4E 47 0D 0A 1A 0A
        if (str_starts_with($bytes, "\x89PNG\r\n\x1a\n")) {
            return 'image/png';
        }

        // GIF87a / GIF89a
        if (str_starts_with($bytes, 'GIF87a') || str_starts_with($bytes, 'GIF89a')) {
            return 'image/gif';
        }

        // WebP: RIFF????WEBP
        if (str_starts_with($bytes, 'RIFF') && substr($bytes, 8, 4) === 'WEBP') {
            return 'image/webp';
        }

        // AVIF / HEIF: ftyp box at byte 4
        if (substr($bytes, 4, 4) === 'ftyp') {
            $brand = substr($bytes, 8, 4);

            if (in_array($brand, ['avif', 'avis', 'heic', 'heix', 'mif1', 'msf1'], true)) {
                return str_starts_with($brand, 'hei') ? 'image/heic' : 'image/avif';
            }
        }

        return null;
    }
}
