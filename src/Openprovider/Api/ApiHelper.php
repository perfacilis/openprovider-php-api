<?php

namespace Openprovider\Api;

use Openprovider\Api\Auth\LoginService;
use Openprovider\Api\Client;
use RuntimeException;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class ApiHelper
{

    /**
     * Shorthand method to set up OpenProvider API client.
     * It'll get the access_token using user and pass stored in Config.
     *
     * @return Client
     */
    public static function getClient(): Client
    {
        if (self::$client) {
            return self::$client;
        }

        $username = config('openprovider.user');
        $password = config('openprovider.pass');

        if (!$username || !$password) {
            throw new RuntimeException('No username or password configured for OpenProvider API.');
        }

        $login_api = new LoginService(new Client(''));
        $access_token = $login_api->login($username, $password);

        self::$client = new Client($access_token);

        return self::$client;
    }

    /**
     * @var Client
     */
    private static $client = null;
}
