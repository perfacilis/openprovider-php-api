<?php

namespace Openprovider\Entities\Base;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class Price extends AbstractEntity
{
    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [
            'product' => PriceInCurrency::class,
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
    protected $product = null;

    /**
     * @var PriceInCurrency
     */
    protected $reseller = null;
}
