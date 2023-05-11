<?php

namespace Portfolio\Config;

use Cloudinary\Cloudinary as CloudinaryConfig;
use Portfolio\Src\Traits\Encrypt;

class Cloudinary
{
    use Encrypt;

    public static function getCongiguration(): CloudinaryConfig
    {
        define('DOTENV', Dotenv::config());

        return new CloudinaryConfig(
            [
                'cloud' => [
                    'cloud_name' => DOTENV['CLOUD_NAME'],
                    'api_key' => DOTENV['CLOUD_KEY'],
                    'api_secret' => DOTENV['CLOUD_SECRET']
                ]
            ]
        );
    }

    public function uploadFile(array $file): bool|string
    {
        if ($file['type'] !== 'image/png' && $file['type'] !== 'image/jpeg') return false;

        $publicId = $this->hashString($file['name']);

        $cloudinary = $this->getCongiguration();
        $cloudinary->uploadApi()->upload(
            $file['full_path'],
            ['public_id' => $publicId]
        );

        return $cloudinary->image($publicId)->toUrl();
    }
}

?>
