<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\PriceInCurrency;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class PriceWithPromoInfo extends AbstractEntity
{
    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [
            'product' => PriceInCurrency::class,
            'promotion_details' => PromoDetails::class,
            'reseller' => PriceInCurrency::class
        ];
    }

    public function getProduct(): PriceInCurrency
    {
        return $this->product;
    }

    public function setProduct(PriceInCurrency $product): void
    {
        $this->product = $product;
    }

    public function getPromotionDetails(): ?PromoDetails
    {
        return $this->promotion_details;
    }

    public function setPromotionDetails(PromoDetails $promotion_details): void
    {
        $this->promotion_details = $promotion_details;
    }

    public function getReseller(): PriceInCurrency
    {
        return $this->reseller;
    }

    public function setReseller(PriceInCurrency $reseller): void
    {
        $this->reseller = $reseller;
    }

    /**
     * @var PriceInCurrency
     */
    private $product = null;

    /**
     * @var PromoDetails
     */
    private $promotion_details = null;

    /**
     * @var PriceInCurrency
     */
    private $reseller = null;
}
