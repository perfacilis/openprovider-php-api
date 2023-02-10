<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Price;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class DomainPrice extends AbstractEntity
{

    /**
     * @var bool
     */
    public $is_premium = false;

    /**
     * @var bool
     */
    public $is_promotion = false;

    public function getMembershipPrice(): Price
    {
        return $this->membership_price;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getPromotionData(): PromotionData
    {
        return $this->promotion_data;
    }

    public function getTierPrice(): Price
    {
        return $this->tier_price;
    }

    public function setMembershipPrice(Price $membership_price): void
    {
        $this->membership_price = $membership_price;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    public function setPromotionData(PromotionData $promotion_data): void
    {
        $this->promotion_data = $promotion_data;
    }

    public function setTierPrice(Price $tier_price): void
    {
        $this->tier_price = $tier_price;
    }

    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [
            'membership_price' => Price::class,
            'price' => Price::class,
            'promotion_data' => Price::class,
            'tier_price' => Price::class,
        ];
    }

    /**
     * @var Price
     */
    private $membership_price = null;

    /**
     * @var Price
     */
    private $price = null;

    /**
     * @var PromotionData
     */
    private $promotion_data = null;

    /**
     * @var Price
     */
    private $tier_price = null;
}
