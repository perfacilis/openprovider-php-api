<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class Tld extends AbstractEntity
{
    public $admin_handle_supported = false;
    public $billing_handle_enabled = false;
    public $billing_handle_supported = false;
    public $dnssec_allowed = false;
    public $dnssec_digests_allowed = false;
    public $dnssec_keys_allowed = false;
    public $dnssec_max_records_amount = 0;
    public $domicile_available = false;
    public $is_auth_code_available = false;
    public $is_auth_code_changeable = false;
    public $is_auth_code_requested = false;
    public $is_private_whois_allowed = false;
    public $is_trade_auth_code_required = false;
    public $is_transfer_auth_code_required = false;
    public $owner_handle_supported = false;
    public $max_period = 0;
    public $min_period = 0;
    public $quarantine_period = 0;
    public $renew_available = false;
    public $reseller_handle_enabled = false;
    public $reseller_handle_supported = false;

    /**
     * @var string[]
     */
    public $restrictions = [];
    public $soft_quarantine_period = 0;

    /**
     * const ACT ???
     */
    public $status = '';
    public $tech_handle_supported = false;
    public $trade_available = false;
    public $transfer_available = false;

    /**
     * @var int Count of domains using specified extension
     */
    public $usage_count = 0;

    public function propertyValueMap(): array
    {
        return [
            'description' => TldDescription::class,
            'prices' => TldPrices::class,
        ];
    }

    public function getSerializableFields(): array
    {
        return [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): TldDescription
    {
        return $this->description;
    }

    public function setDescription(TldDescription $description): void
    {
        $this->description = $description;
    }

    public function getDnssecAlgorithms(): array
    {
        return $this->dnssec_algorithms;
    }

    public function setDnssecAlgorithms(array $dnssec_algorithms): void
    {
        $this->dnssec_algorithms = $dnssec_algorithms;
    }

    public function getPrices(): TldPrices
    {
        return $this->prices;
    }

    public function setPrices(TldPrices $prices): void
    {
        $this->prices = $prices;
    }

    public function getLevelPrices(): array
    {
        return $this->level_prices;
    }

    public function getSupportedApplication_mode(): array
    {
        return $this->supported_application_mode;
    }

    public function getSupportedIdnScripts(): array
    {
        return $this->supported_idn_scripts;
    }

    public function setLevelPrices(array $level_prices): void
    {
        $this->level_prices = [];
        foreach ($level_prices as $level_price) {
            if (!($level_price instanceof TldLevelPrice)) {
                $level_price = new TldLevelPrice($level_price);
            }

            $this->level_prices[] = $level_price;
        }
    }

    public function setSupportedApplicationMode(array $supported_application_mode): void
    {
        $this->supported_application_mode = $supported_application_mode;
    }

    public function setSupportedIdnScripts(array $supported_idn_scripts): void
    {
        $this->supported_idn_scripts = $supported_idn_scripts;
    }

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var TldDescription
     */
    private $description = null;

    /**
     * @var int[]
     */
    private $dnssec_algorithms = [];

    /**
     * @var TldPrices
     */
    private $prices = null;

    /**
     * @var TldLevelPrice[]
     */
    private $level_prices = [];

    /**
     * @var TldApplicationMode[]
     */
    private $supported_application_mode = [];

    /**
     * @var TldIdnScript[]
     */
    private $supported_idn_scripts = [];
}
