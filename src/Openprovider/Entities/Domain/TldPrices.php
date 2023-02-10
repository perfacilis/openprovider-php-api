<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Price;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class TldPrices extends AbstractEntity
{

    /**
     * @var int Maximum operation period
     */
    public $max_period = 0;

    /**
     * @var int Minimal operation period
     */
    public $min_period = 0;

    public function propertyValueMap(): array
    {
        return [
            'create_price' => Price::class,
            'setup_price' => Price::class,
            'domicile_price' => Price::class,
            'renew_price' => Price::class,
            'reseller_price' => PriceWithPromoInfo::class,
            'restore_price' => Price::class,
            'setup_price' => Price::class,
            'soft_restore_price' => Price::class,
            'trade_price' => Price::class,
            'transfer_price' => Price::class,
            'update_price' => Price::class
        ];
    }

    public function getSerializableFields(): array
    {
        return [];
    }

    public function getCreatePrice(): ?Price
    {
        return $this->create_price;
    }

    public function getDomicilePrice(): ?Price
    {
        return $this->domicile_price;
    }

    public function getRenewPrice(): ?Price
    {
        return $this->renew_price;
    }

    public function getResellerPrice(): ?PriceWithPromoInfo
    {
        return $this->reseller_price;
    }

    public function getRestorePrice(): ?Price
    {
        return $this->restore_price;
    }

    public function getSetupPrice(): ?Price
    {
        return $this->setup_price;
    }

    public function getSoftRestorePrice(): ?Price
    {
        return $this->soft_restore_price;
    }

    public function getTradePrice(): ?Price
    {
        return $this->trade_price;
    }

    public function getTransferPrice(): ?Price
    {
        return $this->transfer_price;
    }

    public function getUpdatePrice(): ?Price
    {
        return $this->update_price;
    }

    public function setCreatePrice(Price $create_price): void
    {
        $this->create_price = $create_price;
    }

    public function setDomicilePrice(Price $domicile_price): void
    {
        $this->domicile_price = $domicile_price;
    }

    public function setRenewPrice(Price $renew_price): void
    {
        $this->renew_price = $renew_price;
    }

    public function setResellerPrice(PriceWithPromoInfo $reseller_price): void
    {
        $this->reseller_price = $reseller_price;
    }

    public function setRestorePrice(Price $restore_price): void
    {
        $this->restore_price = $restore_price;
    }

    public function setSetupPrice(Price $setup_price): void
    {
        $this->setup_price = $setup_price;
    }

    public function setSoftRestorePrice(Price $soft_restore_price): void
    {
        $this->soft_restore_price = $soft_restore_price;
    }

    public function setTradePrice(Price $trade_price): void
    {
        $this->trade_price = $trade_price;
    }

    public function setTransferPrice(Price $transfer_price): void
    {
        $this->transfer_price = $transfer_price;
    }

    public function setUpdatePrice(Price $update_price): void
    {
        $this->update_price = $update_price;
    }

    /**
     * @var Price
     */
    private $create_price = null;

    /**
     * @var Price
     */
    private $domicile_price = null;

    /**
     * @var Price
     */
    private $renew_price = null;

    /**
     * @var PriceWithPromoInfo
     */
    private $reseller_price = null;

    /**
     * @var Price
     */
    private $restore_price = null;

    /**
     * @var Price
     */
    private $setup_price = null;

    /**
     * @var Price
     */
    private $soft_restore_price = null;

    /**
     * @var Price
     */
    private $trade_price = null;

    /**
     * @var Price
     */
    private $transfer_price = null;

    /**
     * @var Price
     */
    private $update_price = null;
}
