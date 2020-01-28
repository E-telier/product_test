<?php

namespace App\Service;

class APIAccess
{

    public function __construct()
    {

    }

    public function callAPI($method, $url, $data = false)
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        switch ($method) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);

                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }

                break;
            case "PUT":
            case "DELETE":
                  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }

        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
