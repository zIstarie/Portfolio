<?php

namespace Portfolio\Config;

use Cloudinary\Cloudinary as CloudinaryConfig;
use Exception;
use Portfolio\Src\Traits\Encrypt;
use Portfolio\Src\Traits\LogRegister;

class Cloudinary
{
    use Encrypt;
    use LogRegister;

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
        try {
            if ($file['type'] !== 'image/png' && $file['type'] !== 'image/jpeg') return false;
    
            $publicId = $this->hashString($file['name']);
    
            $cloudinary = $this->getCongiguration();
            $cloudinary->uploadApi()->upload(
                $file['full_path'],
                ['public_id' => $publicId]
            );
    
            return $cloudinary->image($publicId)->toUrl();
        } catch (Exception $e) {
            $this->registerLogFile('Erro ao fazer upload de imagem na Cloudinary', $e);
            return false;
        }
    }
}

?>
