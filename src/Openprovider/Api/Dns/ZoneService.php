<?php

namespace Openprovider\Api\Dns;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Dns\Zone;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class ZoneService extends AbstractService
{
    public const ENDPOINT = '/dns/zones';

    /**
     * @return Zone[]
     */
    public function list(int $offset = 0, int $limit = 100): array
    {
        $response = $this->client->get(self::ENDPOINT, [
            'offset' => $offset,
            'limit' => $limit
        ]);

        $results = [];
        foreach ($response['data']['results'] as $result) {
            $zone = new Zone($result);
            $results[] = $zone;
        }

        return $results;
    }

    /**
     * @param string $name_pattern
     * @return Zone[]
     */
    public function search(string $name_pattern): array
    {
        $resp = $this->client->get(self::ENDPOINT, [
            'name_pattern' => $name_pattern
        ]);
        
        $zones = [];
        foreach ($resp['data']['results'] as $zone) {
            $zones[] = new Zone($zone);
        }

        return $zones;
    }


    /**
     * @return \Generator|Zone[]
     */
    public function listAll(): \Generator
    {
        return $this->listAllGenerator();
    }

    /**
     * @param string $domain_name
     * @param int $id
     * @param bool $with_records
     * @param bool $with_history
     * @param bool $with_dnskey
     * @return Zone|null
     */
    public function get(string $domain_name, int $id = 0, bool $with_records = false, bool $with_history = false, bool $with_dnskey = false): ?Zone
    {
        $params = [];
        if ($id) {
            $params['id'] = $id;
        }

        if ($with_records) {
            $params['with_records'] = true;
        }

        if ($with_history) {
            $params['with_history'] = true;
        }

        if ($with_dnskey) {
            $params['width_dnskey'] = true;
        }

        $response = $this->client->get(self::ENDPOINT . '/' . $domain_name, $params);
        if (!isset($response['data'])) {
            return null;
        }

        $zone_data = $response['data'];
        $zone = new Zone($zone_data);

        return $zone;
    }

    public function create(Zone $zone): bool
    {
        $params = $zone->jsonSerialize();
        $response = $this->client->post(self::ENDPOINT, $params);

        return isset($response['data']['success']) ? $response['data']['success'] : false;
    }

    /**
     * Update Dns Zone
     * @param \Openprovider\Entities\Dns\Zone $zone
     * @param \Openprovider\Entities\Dns\ZoneRecord[] $add_records
     * @param \Openprovider\Entities\Dns\ZoneRecord[] $remove_records
     * @param \Openprovider\Entities\Dns\ZoneRecord[] $replace_records
     * @return bool
     * @todo Records don't always seem to be removed, perhaps API beta?
     */
    public function update(Zone $zone, array $add_records = [], array $remove_records = [], array $replace_records = []): bool
    {
        $params = $zone->jsonSerialize();
        $params['id'] = $zone->id;
        $params['name'] = $zone->getName();

        if ($add_records) {
            $params['records']['add'] = [];
            foreach ($add_records as $record) {
                $params['records']['add'][] = $record->jsonSerialize();
            }
        }

        if ($remove_records) {
            $params['records']['remove'] = [];
            foreach ($remove_records as $record) {
                $params['records']['remove'][] = $record->jsonSerialize();
            }
        }

        if ($replace_records) {
            $params['records']['replace'] = [];
            foreach ($replace_records as $record) {
                $params['records']['replace'][] = $record->jsonSerialize();
            }
        }

        $response = $this->client->put(self::ENDPOINT . '/' . $zone->getName(), $params);
        return isset($response['data']['success']) ? $response['data']['success'] : false;
    }

    public function delete(Zone $zone): bool
    {
        $response = $this->client->delete(self::ENDPOINT . '/' . $zone->getName());
        return isset($response['data']['success']) ? $response['data']['success'] : false;
    }
}
