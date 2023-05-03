<?php

namespace Portfolio\Config;

use Cloudinary\Cloudinary as CloudinaryConfig;

class Cloudinary
{
    private static const DOTENV = Dotenv::config();

    public function getCongiguration(): CloudinaryConfig
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
}

?>
