<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Domain as BaseDomain;
use Openprovider\Entities\Domain\AbuseDetails;
use Openprovider\Entities\Domain\AdditionalData;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class Domain extends AbstractEntity
{

    /**
     * Renewal
     */
    public const RENEW_DEFAULT = 'default';
    public const RENEW_OFF = 'off';
    public const RENEW_ON = 'on';

    /**
     * DNSSEC
     */
    public const DNSSEC_UNSIGNED = 'unsigned';
    public const DNSSEC_SIGNED = 'signedDelegation';

    /**
     * Unit of time to register domain
     */
    public const UNIT_YEARLY = 'yearly';
    public const UNIT_QUARTERLY = 'quarterly';
    public const UNIT_MONTHLY = 'monthly';

    public $active_date = '';
    public $admin_handle = '';
    public $application_id = '';
    public $application_mode = '';
    public $application_mode_expiration_date = '';
    public $application_mode_title = '';
    public $application_notice_id = '';
    public $application_smd = '';
    public $auth_code = '';
    public $autorenew = self::RENEW_DEFAULT;
    public $billing_handle = '';
    public $can_renew = '';
    public $comments = '';
    public $comments_last_changed_at = '';
    public $creation_date = '';
    public $delete_status = '';
    public $deleted_at = '';
    public $dnssec = self::DNSSEC_UNSIGNED;
    public $expiration_date = '';
    public $hard_quarantine_expiry_date = '';
    public $has_history = false;
    public $id = 0;
    public $internal_auth_code = '';
    public $is_abusive = false;
    public $is_client_hold_enabled = '';
    public $is_deleted = false;
    public $is_dnssec_enabled = false;
    public $is_hosted_whois = false;
    public $is_lockable = false;
    public $is_locked = false;
    public $is_premium = false;
    public $is_private_whois_allowed = false;
    public $is_private_whois_enabled = false;
    public $is_spamexperts_enabled = false;
    public $last_changed = '';
    public $modify_owner_allowed = false;
    public $ns_group = '';
    public $ns_template_id = 0;
    public $ns_template_name = '';
    public $nsgroup_id = 0;
    public $order_date = '';
    public $owner_company_name = '';
    public $owner_handle = '';
    public $quarantine_expiration_date = '';
    public $registry_expiration_date = '';
    public $renew = 0;
    public $renewal_date = '';
    public $reseller_handle = '';
    public $reseller_id = 0;
    public $restorable_until = '';
    public $scheduled_at = '';
    public $scheduled_from = '';
    public $soft_quarantine_expiry_date = '';
    public $status = '';
    public $tech_handle = '';
    public $trade_allowed = false;
    public $trade_auth_code_required = '';
    public $transfer_auth_code_required = '';
    public $transfer_cancel_supported = false;
    public $type = '';
    public $unit = self::UNIT_YEARLY;
    public $use_domicile = false;
    public $verification_email_exp_date = '';
    public $verification_email_name = '';
    public $verification_email_status = '';
    public $verification_email_status_description = '';

    /**
     * @see https://docs.openprovider.com/doc/all#operation/UpdateDomain
     * @return array
     */
    public function getSerializableFields(): array
    {
        return [
            // 'accept_update_fee',
            'additional_data',
            'admin_handle',
            // 'auth_code',
            'autorenew',
            'billing_handle',
            'comments',
            'dnssec_keys',
            'domain',
            // 'force_registry_update',
            'id',
            'is_dnssec_enabled',
            'is_locked',
            'is_private_whois_enabled',
            // 'is_sectigo_dns_enabled',
            'is_spamexperts_enabled',
            'name_servers',
            'ns_group',
            'ns_template_id',
            'ns_template_name',
            'owner_handle',
            // 'remove_nses',
            'reseller_handle',
            // 'reset_auth_code',
            'scheduled_at',
            'tech_handle',
            'use_domicile',
        ];
    }

    public function propertyValueMap(): array
    {
        return [
            'abuse_details' => AbuseDetails::class,
            'additional_data' => AdditionalData::class,
            'domain' => BaseDomain::class,
            'owner' => Owner::class,
            'whois_privacy_data' => WhoisPrivacyData::class,
        ];
    }

    public function getAbuseDetails(): ?AbuseDetails
    {
        return $this->abuse_details;
    }

    public function setAbuseDetails(AbuseDetails $abuse_details): void
    {
        $this->abuse_details = $abuse_details;
    }

    public function getAdditionalData(): ?AdditionalData
    {
        return $this->additional_data;
    }

    public function setAdditionalData(AdditionalData $additional_data): void
    {
        $this->additional_data = $additional_data;
    }

    public function getApiHistory(): array
    {
        return $this->api_history;
    }

    public function setApiHistory(array $api_history): void
    {
        $this->api_history = [];
        foreach ($api_history as $history) {
            $this->api_history[] = new ApiHistory($history);
        }
    }

    public function getDnssecKeys(): array
    {
        return $this->dnssec_keys;
    }

    public function setDnssecKeys(array $dnssec_keys): void
    {
        $this->dnssec_keys = [];
        foreach ($dnssec_keys as $key) {
            $this->dnssec_keys[] = new DnsSecKey($key);
        }
    }

    public function getDomain(): BaseDomain
    {
        return $this->domain;
    }

    public function setDomain(BaseDomain $domain): void
    {
        $this->domain = $domain;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function setHistory(array $history): void
    {
        $this->history = [];
        foreach ($history as $item) {
            $this->history[] = new History($item);
        }
    }

    public function getNameServers(): array
    {
        return $this->name_servers;
    }

    public function setNameServers(array $name_servers): void
    {
        $this->name_servers = [];
        foreach ($name_servers as $ns) {
            $this->name_servers[] = new NameServer($ns);
        }
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): void
    {
        $this->owner = $owner;
    }

    public function getRegistryStatuses(): array
    {
        return $this->registry_statuses;
    }

    public function setRegistryStatuses(array $registry_statuses): void
    {
        $this->registry_statuses = [];
        foreach ($registry_statuses as $rststus) {
            $this->registry_statuses[] = new RegistryStatus($rststus);
        }
    }

    public function getWhoisPrivacyData(): ?WhoisPrivacyData
    {
        return $this->whois_privacy_data;
    }

    public function setWhoisPrivacyData(WhoisPrivacyData $whois_privacy_data): void
    {
        $this->whois_privacy_data = $whois_privacy_data;
    }

    /**
     * @var AbuseDetails
     */
    private $abuse_details = null;

    /**
     * @var AdditionalData
     */
    private $additional_data = null;

    /**
     * @var ApiHistory[]
     */
    private $api_history = [];

    /**
     * @var DnsSecKey[]
     */
    private $dnssec_keys = [];

    /**
     * @var BaseDomain
     */
    private $domain = null;

    /**
     * @var History[]
     */
    private $history = [];

    /**
     * @var NameServer[]
     */
    private $name_servers = [];

    /**
     * @var Owner
     */
    private $owner = null;

    /**
     * @var RegistryStatuses[]
     */
    private $registry_statuses = [];

    /**
     * @var WhoisPrivacyData
     */
    private $whois_privacy_data = null;
}
