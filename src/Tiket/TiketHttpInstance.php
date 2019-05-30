<?php

namespace Tiket;

class TiketHttpInstance
{
    private static $instance      = null;
    private static $settings = array(
        'business_id' => '',
        'business_name' => '',
        'client_secret' => '',
        'headers-agent' => '',
        'curl_options' => array(),
        'options' => array(
            'host' => 'api-sandbox.tiket.com',
            'scheme' => 'https',
            'timeout' => 60,
            'port' => 443,
            'timezone' => 'Asia/Jakarta'
        )
    );

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getTiketHttp()
    {
        if (self::$instance !== null) {
            return self::$instance;
        }
        self::$instance = new TiketHttp(
            self::$settings['client_secret'],
            self::$settings['business_id'],
            self::$settings['business_name'],
            self::$settings['options']
        );
        return self::$instance;
    }
}
