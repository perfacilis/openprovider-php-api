<?php

namespace Openprovider\Api\Domain;

use InvalidArgumentException;
use Openprovider\Api\AbstractService;
use Openprovider\Entities\Base\BaseDomain;
use Openprovider\Entities\Domain\DomainPrice;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class PricesService extends AbstractService
{
    const ENDPOINT = 'domains/prices';

    /**
     * Operation
     */
    public const OPERATION_CREATE = 'create';
    public const OPERATION_TRANSFER = 'transfer';
    public const OPERATION_RENEW = 'renew';
    public const OPERATION_RESTORE = 'restore';
    public const OPERATION_TRADE = 'trade';
    public const OPERATION_UPGRADE = 'upgrade';

    public static function getAllowedOperations(): array
    {
        return [
            self::OPERATION_CREATE, self::OPERATION_TRANSFER,
            self::OPERATION_RENEW, self::OPERATION_RESTORE,
            self::OPERATION_TRADE, self::OPERATION_UPGRADE
        ];
    }

    /**
     * @see https://docs.openprovider.com/doc/all#tag/DomainPriceService
     * @see https://support.openprovider.eu/hc/en-us/articles/360023776313
     * @param BaseDomain $domain
     */
    public function get(BaseDomain $domain, string $operation = self::OPERATION_CREATE): ?DomainPrice
    {
        $allowed_operations = self::getAllowedOperations();
        if (!in_array($operation, $allowed_operations)) {
            throw new InvalidArgumentException(sprintf(
                'Given operation \'%s\' is not valid, use one of these: %s.',
                $operation,
                implode(', ', $allowed_operations)
            ));
        }

        $resp = $this->client->get(self::ENDPOINT, [
            'domain.extension' => $domain->extension,
            'domain.name' => $domain->name,
            'operation' => $operation
        ]);

        if (!isset($resp['data'])) {
            return null;
        }

        $domain_price_data = $resp['data'];
        $domain_price = new DomainPrice($domain_price_data);

        return $domain_price;
    }
}
