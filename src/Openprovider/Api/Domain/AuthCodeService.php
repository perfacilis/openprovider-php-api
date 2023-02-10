<?php

namespace Openprovider\Api\Domain;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Domain\Domain;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class AuthCodeService extends AbstractService
{
    public const AUTH_CODE_TYPE_INTERNAL = 'internal';
    public const AUTH_CODE_TYPE_EXTERAL = 'external';

    /**
     * Reset external auth code, return new auth code or empty if fails
     * @param Domain $domain
     * @return string
     */
    public function reset(Domain $domain): string
    {
        $resp = $this->client->post($this->getEndpoint($domain->id));
        return isset($resp['data']['auth_code']) ? $resp['data']['auth_code'] : '';
    }

    private function getEndpoint(int $domain_id_number): string
    {
        return sprintf('/domains/%1$d/authcode/reset', $domain_id_number);
    }
}
