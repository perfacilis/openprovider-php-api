<?php

namespace Openprovider\Api\Domain;

use Openprovider\Api\AbstractService;
use Openprovider\Entities\Domain\Domain;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class DomainService extends AbstractService
{
    const ENDPOINT = '/domains';

    /**
     * @param int $offset
     * @param int $limit
     * @return Domain[]
     */
    public function list(int $offset = 0, int $limit = 100): array
    {
        $query = new DomainQuery();
        $query->offset = $offset;
        $query->limit = $limit;
        $params = $query->jsonSerialize();

        $resp = $this->client->get(self::ENDPOINT, $params);

        if (!isset($resp['data']['results'])) {
            return [];
        }

        $results = [];
        foreach ($resp['data']['results'] as $result) {
            $domain = new Domain($result);
            $results[] = $domain;
        }

        return $results;
    }

    /**
     * @return Generator|Domain[]
     */
    public function listAll(): \Generator
    {
        return $this->listAllGenerator();
    }

    /**
     * @param DomainQuery $query
     * @return Domain[]
     */
    public function search(DomainQuery $query): array
    {
        $params = $query->jsonSerialize();
        $resp = $this->client->get(self::ENDPOINT, $params);

        if (!isset($resp['data']['results'])) {
            return [];
        }

        $domains = [];
        foreach ($resp['data']['results'] as $domain) {
            $domains[] = new Domain($domain);
        }

        return $domains;
    }

    /**
     * Get domain details
     *
     * @param int $id
     * @param bool $history Include history
     * @param bool $api_history Include api history
     * @param bool $additional_data Include addtional data
     * @param bool $verification_email Include verification email
     * @param bool $abuse_details Include abuse details
     * @param bool $whois_privacy_data Include whois privacy data
     * @param bool $registry_issues Include registry issues
     * @return Domain|null
     */
    public function get(
        int $id,
        bool $history = false,
        bool $api_history = false,
        bool $additional_data = false,
        bool $verification_email = false,
        bool $abuse_details = false,
        bool $whois_privacy_data = false,
        bool $registry_issues = false
    ): ?Domain {
        $resp = $this->client->get(self::ENDPOINT . '/' . $id, [
            'with_history' => $history,
            'with_api_history' => $api_history,
            'with_additional_data' => $additional_data,
            'with_verification_email' => $verification_email,
            'with_abuse_details' => $abuse_details,
            'with_whois_privacy_data' => $whois_privacy_data,
            'with_registry_issues' => $registry_issues,
        ]);

        if (!isset($resp['data'])) {
            return null;
        }

        $domain_data = $resp['data'];
        $domain = new Domain($domain_data);

        return $domain;
    }

    /**
     * @see https://docs.openprovider.com/doc/all#operation/UpdateDomain
     * @param Domain $domain
     * @return bool
     */
    public function update(Domain $domain): bool
    {
        $resp = $this->client->put(
            self::ENDPOINT . '/' . $domain->id,
            $domain->jsonSerialize()
        );

        // Empty response means bad result
        return !empty($resp['data']);
    }
}
