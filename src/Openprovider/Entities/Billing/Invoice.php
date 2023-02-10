<?php

namespace Openprovider\Entities\Billing;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Price;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class Invoice extends AbstractEntity
{
    public $attachment_url = '';
    public $creation_date = '';
    public $id = 0;
    public $invoice_number = '';
    public $invoice_url = '';

    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [
            'amount' => Price::class,
        ];
    }

    public function getAmount(): Price
    {
        return $this->amount;
    }

    public function setAmount(Price $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @var Price
     */
    private $amount = null;
}
