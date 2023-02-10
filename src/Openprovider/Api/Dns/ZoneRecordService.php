<?php

namespace Openprovider\Api\Dns;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Dns\Zone;
use Openprovider\Entities\Dns\ZoneRecord;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class ZoneRecordService extends AbstractService
{
    public const ENDPOINT = '/dns/zones/%s/records';

    /**
     * @param string $domain_name
     * @return ZoneRecord[]
     */
    public function list(string $domain_name, int $offset = 0, int $limit = 100): array
    {
        $response = $this->client->get(sprintf(self::ENDPOINT, $domain_name), [
            'offset' => $offset,
            'limit' => $limit
        ]);

        $results = [];
        foreach ($response['data']['results'] as $result) {
            // Fix name: "mail.domain.tld" > "mail" and "domain.tld" > ""
            if (strpos($result['name'], $domain_name) !== false) {
                $result['name'] = preg_replace('/\.*(' . preg_quote($domain_name) . ')$/', '', $result['name']);
            }

            $zonerecord = new ZoneRecord($result);
            $results[] = $zonerecord;
        }

        return $results;
    }

    /**
     * Get all records, without paging
     * @param string $domain_name
     * @return \Generator|ZoneRecord[]
     */
    public function listAll(string $domain_name): \Generator
    {
        return $this->listAllGenerator($domain_name);
    }

    /**
     * Build an array of records to be added to a zone based on a list of ALL records
     *
     * @param \Openprovider\Entities\Dns\Zone $zone
     * @param \Openprovider\Entities\Dns\ZoneRecord[] $records
     * @return \Openprovider\Entities\Dns\ZoneRecord[]
     */
    public function getRecordsToAdd(Zone $zone, array $records): array
    {
        // Assume all records need ot be added, set UID key
        $add_records = [];
        foreach ($records as $record) {
            $uid = $record->getUid();
            $add_records[$uid] = $record;
        }

        $existing_records = $this->listAll($zone->getName());
        foreach ($existing_records as $record) {
            $uid = $record->getUid();
            if (isset($add_records[$uid])) {
                unset($add_records[$uid]);
            }
        }

        // Filter out read only
        $add_records = $this->filterReadonlyRecords($add_records);

        // Return the remainder
        return array_values($add_records);
    }

    /**
     * Build an array of records to be removed from a zone based on a list of ALL records
     *
     * @param \Openprovider\Entities\Dns\Zone $zone
     * @param \Openprovider\Entities\Dns\ZoneRecord[] $records
     * @return \Openprovider\Entities\Dns\ZoneRecord[]
     */
    public function getRecordsToRemove(Zone $zone, array $records): array
    {
        $remove_records = [];

        // Add UID index to records
        foreach ($records as $i => $record) {
            $uid = $record->getUid();
            $records[$uid] = $record;
            unset($records[$i]);
        }

        $existing_records = $this->listAll($zone->getName());
        foreach ($existing_records as $record) {
            $uid = $record->getUid();
            if (!isset($records[$uid])) {
                $remove_records[] = $record;
            }
        }

        // Filter out read only
        $remove_records = $this->filterReadonlyRecords($remove_records);

        // Return the remainder
        return $remove_records;
    }

    /**
     * Remove records we don't want changed trough API
     *
     * @param array $records
     * @return array
     */
    private function filterReadonlyRecords(array $records): array
    {
        return array_filter($records, function ($record) {
            return !$record->isReadonly();
        });
    }
}
