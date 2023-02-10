<?php

namespace Openprovider\Entities\Billing;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Price;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class Transaction extends AbstractEntity
{
    public $action = '';
    public $creation_date = '';
    public $discount = 0;
    public $exchange_rate = 0;
    public $object_type = '';
    public $quantity = 0;
    public $reference_id = 0;
    public $subject = '';
    public $type = '';
    public $vat = 0;

    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [
            'price' => Price::class,
            'setup' => Price::class,
            'total' => Price::class,
        ];
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    public function getSetup(): Price
    {
        return $this->setup;
    }

    public function setSetup(Price $setup): void
    {
        $this->setup = $setup;
    }

    public function getTotal(): Price
    {
        return $this->total;
    }

    public function setTotal(Price $total): void
    {
        $this->total = $total;
    }

    /**
     * @var Price
     */
    private $price = null;

    /**
     * @var Price
     */
    private $setup = null;

    /**
     * @var Price
     */
    private $total = null;
}
