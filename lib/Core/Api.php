<?php
namespace IndicoPlus\CaritasApp\Core;

use IndicoPlus\CaritasApp\Traits\Singleton;

class Api
{
    use Singleton;

    const BASE_PATH = 'https://aplikacjacaritas.pl';

    public function get(string $path = '', array $query = [])
    {
        $path = $this->getUrl($path);
        $url = $path . '?' . http_build_query($query);

        $handle = curl_init($url);
        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $res = curl_exec($handle);

        $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        if ($responseCode !== 200) {
            return null;
        }

        $json = json_decode($res);
        if (!$json) {
            return null;
        }

        return $json;
    }

    public function post(string $path = '', array $data = [])
    {
        $url = $this->getUrl($path);

        $handle = curl_init($url);
        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ]);

        $res = curl_exec($handle);

        $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        if ($responseCode !== 200) {
            return null;
        }

        $json = json_decode($res);
        if (!$json) {
            return null;
        }

        return $json;
    }

    public function getUrl(string $url = '')
    {
        $url = trim($url, '/');
        if (strpos($url, static::BASE_PATH) === 0) {
            return $url;
        }

        return static::BASE_PATH . '/api/' . $url;
    }
}
