<?php

namespace Openprovider\Api\Billing;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Billing\Payment;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class PaymentService extends AbstractService
{
    const ENDPOINT = '/payments';

    public function list(PaymentQuery $query = null): array
    {
        $params = [];
        if ($query) {
            $params = $query->jsonSerialize();
        }

        $resp = $this->client->get(self::ENDPOINT, $params);

        if (!isset($resp['data']['results'])) {
            return [];
        }

        $results = [];
        foreach ($resp['data']['results'] as $result) {
            $domain = new Payment($result);
            $results[] = $domain;
        }

        return $results;
    }
}
