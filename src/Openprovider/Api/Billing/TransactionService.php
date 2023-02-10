<?php

namespace Openprovider\Api\Billing;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Billing\Transaction;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class TransactionService extends AbstractService
{
    const ENDPOINT = '/transactions';

    /**
     * @param TransactionQuery $query
     * @return Transaction[]
     */
    public function list(TransactionQuery $query = null): array
    {
        $params = [];
        if ($query) {
            $params = array_filter($query->jsonSerialize());
        }

        $resp = $this->client->get(self::ENDPOINT, $params);


        if (!isset($resp['data']['results'])) {
            return [];
        }

        $results = [];
        foreach ($resp['data']['results'] as $result) {
            $domain = new Transaction($result);
            $results[] = $domain;
        }

        return $results;
    }
}
