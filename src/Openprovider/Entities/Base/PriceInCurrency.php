<?php

namespace Openprovider\Entities\Base;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class PriceInCurrency extends AbstractEntity
{

    /**
     * @var string
     */
    public $currency = '';

    /**
     * @var double
     */
    public $price = 0.00;

    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [];
    }
}
