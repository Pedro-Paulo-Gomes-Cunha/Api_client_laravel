<?php
namespace App\Services;

class ApiConfig{

public static function GetApiUrlBase(){
    return $_ENV['NEWS_API_BASE'];
}
public static function GetApiKey(){
    return $_ENV['NEWS_API_KEY'];
}


/*public static function api_config(){
    return [
            'base_url' => $_ENV['NEWS_API_BASE'],
            'api_key' => $_ENV['NEWS_API_KEY'],
        ];
}*/
}

