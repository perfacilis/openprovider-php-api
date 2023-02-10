<?php

namespace Openprovider\Api\Domain;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Domain\Tld;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class TldService extends AbstractService
{
    public const ENDPOINT = '/tlds';

    /**
     * @param int $offset
     * @param int $limit
     * @return Tld[]
     */
    public function list(int $offset = 0, int $limit = 100): array
    {
        $resp = $this->client->get(self::ENDPOINT, [
            'offset' => $offset,
            'limit' => $limit,
            // 'name_pattern' => 'eu',
        ]);

        $results = [];
        foreach ($resp['data']['results'] as $result) {
            $tld = new Tld($result);
            $results[] = $tld;
        }

        return $results;
    }

    /**
     * Generator to yield als Tlds
     * @return Generator
     */
    public function listAll(): \Generator
    {
        return $this->listAllGenerator();
    }

    public function get(
        string $name,
        bool $widh_description = false,
        bool $with_restrictions = false,
        bool $with_price = false,
        bool $with_level_prices = false,
        bool $with_usage_count = false
    ): ?Tld {
        $params = [
            'with_description' => $widh_description,
            'with_restrictions' => $with_restrictions,
            'with_price' => $with_price,
            'with_level_prices' => $with_level_prices,
            'with_usage_count' => $with_usage_count,
        ];

        $resp = $this->client->get(self::ENDPOINT . '/' . $name, $params);
        if (!isset($resp['data'])) {
            return null;
        }

        $tld_data = $resp['data'];
        $tld = new Tld($tld_data);

        return $tld;
    }
}
