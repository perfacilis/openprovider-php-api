<?php

namespace Openprovider\Api;

use Exception;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class Client
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    public function __construct(string $access_token)
    {
        $this->access_token = $access_token;
    }

    public function get(string $endpoint, array $params = []): array
    {
        return $this->request(self::METHOD_GET, $endpoint, $params);
    }

    public function post(string $endpoint, array $params = []): array
    {
        return $this->request(self::METHOD_POST, $endpoint, $params);
    }

    public function put(string $endpoint, array $params = []): array
    {
        return $this->request(self::METHOD_PUT, $endpoint, $params);
    }

    public function delete(string $endpoint, array $params = []): array
    {
        return $this->request(self::METHOD_DELETE, $endpoint, $params);
    }

    private const BASEURL = 'https://api.openprovider.eu/v1beta';

    private $access_token = '';

    /**
     * Call to API using Curl
     *
     * @see https://php.watch/articles/php-curl-security-hardening
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @return array
     * @throws Exception
     */
    private function request(string $method, string $endpoint, array $params = []): array
    {
        $url = self::BASEURL . '/' . trim($endpoint, '/');
        if ($method === self::METHOD_GET && $params) {
            $url .= '?' . $this->buildQuery($params);
        }

        $headers = [
            'Content-Type: application/json'
        ];

        if ($this->access_token) {
            $headers[] = 'Authorization: Bearer ' . $this->access_token;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30
        ]);

        if (defined('CURLOPT_PROTOCOLS')) {
            curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        }

        if ($params) {
            $params = json_encode($params);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        $json = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($status_code < 200 || $status_code > 299) {
            throw new Exception(sprintf(
                '[%d] Error %d from %s: %s',
                $status_code,
                $errno,
                $url,
                $json
            ));
        }

        if (!$json) {
            throw new Exception(sprintf('Empty result from %s', $url));
        }

        $output = json_decode($json, true);
        if (!$output) {
            throw new Exception(sprintf('Invalid JSON from %s: %s.', $url, $json));
        }

        return $output;
    }

    private function buildQuery(array $params): string
    {
        foreach ($params as &$v) {
            switch (gettype($v)) {
                case 'bool':
                case 'boolean':
                    $v = $v ? 'true' : 'false';
                    break;
            }
        }

        return http_build_query($params);
    }
}
