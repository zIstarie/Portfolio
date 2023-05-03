<?php

namespace Portfolio\Config;

use Cloudinary\Cloudinary as CloudinaryConfig;
use Portfolio\Src\Traits\Encrypt;

class Cloudinary
{
    use Encrypt;

    private static const DOTENV = Dotenv::config();

    public static function getCongiguration(): CloudinaryConfig
    {
        return new CloudinaryConfig(
            [
                'cloud' => [
                    'cloud_name' => self::DOTENV['CLOUD_NAME'],
                    'api_key' => self::DOTENV['CLOUD_KEY'],
                    'api_secret' => self::DOTENV['CLOUD_SECRET']
                ]
            ]
        );
    }

    public function uploadFile(array $file): bool|string
    {
        if ($file['type'] !== 'image/png' || $file['type'] !== 'image/jpeg') return false;

        $publicId = $this->hashString($file['name']);

        $cloudinary = self::getCongiguration();
        $cloudinary->uploadApi()->upload(
            $file['full_path'],
            ['public_id' => $publicId]
        );

        return $cloudinary->image($publicId)->toUrl();
    }
}

?>
