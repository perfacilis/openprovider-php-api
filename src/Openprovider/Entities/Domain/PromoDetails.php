<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Price;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class PromoDetails extends AbstractEntity
{
    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [
            'non_promo_price' => Price::class
        ];
    }

    public function getEndDate(): string
    {
        return $this->end_date;
    }

    public function setEndDate(string $end_date): void
    {
        $this->end_date = $end_date;
    }

    public function getNonPromoPrice(): Price
    {
        return $this->non_promo_price;
    }

    public function setNonPromoPrice(Price $non_promo_price): void
    {
        $this->non_promo_price = $non_promo_price;
    }

    public function getStartDate(): string
    {
        return $this->start_date;
    }

    public function setStartDate(string $start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @var string Date
     */
    private $end_date = '';

    /**
     * @var Price
     */
    private $non_promo_price = null;

    /**
     * @var string Date
     */
    private $start_date = '';
}
