<?php

namespace Openprovider\Api\Auth;

use Openprovider\Api\AbstractService;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class LoginService extends AbstractService
{
    public const ENDPOINT = '/auth/login';

    public function login(string $username, string $password): string
    {
        $resp = $this->client->post(self::ENDPOINT, [
            'username' => $username,
            'password' => $password
        ]);

        return isset($resp['data']['token']) ? $resp['data']['token'] : '';
    }
}
