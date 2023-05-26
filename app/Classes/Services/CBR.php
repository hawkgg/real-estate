<?php

namespace App\Classes\Services;

class CBR {
    public static function sendQuery() {
        $curl = curl_init('https://www.cbr-xml-daily.ru/latest.js');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function getRates(): array {
        return (array) json_decode(self::sendQuery())?->rates;
    }
}
