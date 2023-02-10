<?php

namespace Openprovider\Api\Billing;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Billing\Invoice;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class InvoiceService extends AbstractService
{
    const ENDPOINT = '/invoices';

    public function list(InvoiceQuery $query = null): array
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
            $invoice = new Invoice($result);
            $results[] = $invoice;
        }

        return $results;
    }
}
