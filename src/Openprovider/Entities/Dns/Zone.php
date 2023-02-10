<?php

namespace Openprovider\Entities\Dns;

use DateTime;
use InvalidArgumentException;
use Openprovider\Entities\AbstractEntity;
use Openprovider\Entities\Base\Domain;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class Zone extends AbstractEntity
{
    const TYPE_MASTER = 'master';
    const TYPE_SLAVE = 'slave';

    /**
     * @var int
     */
    public $id = 0;

    /**
     * @var int
     */
    public $reseller_id = 0;

    /**
     * @var string ipv4 or ipv6
     */
    public $ip = '';

    /**
     * @var bool
     */
    public $active = true;

    /**
     * @var DateTime
     */
    public $creation_date = null;

    /**
     * @var DateTime
     */
    public $modification_date = null;

    /**
     * @var bool
     */
    public $is_spamexperts_enabled = false;

    /**
     * @var bool
     */
    public $is_shadow = false;

    /**
     * @var bool
     */
    public $is_deleted = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $domain_and_tld): void
    {
        $this->name = $domain_and_tld;

        // Update domain object
        list($name, $extension) = explode('.', $domain_and_tld, 2);
        $this->domain = new Domain();
        $this->domain->name = $name;
        $this->domain->extension = $extension;
    }

    public function getDomain(): Domain
    {
        return $this->domain;
    }

    public function setDomain(Domain $domain): void
    {
        $this->domain = $domain;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $allowed = [self::TYPE_MASTER, self::TYPE_SLAVE];
        if (!in_array($type, $allowed)) {
            throw new InvalidArgumentException(sprintf(
                'Given type \'%s\' is not valid, use one of these: %s',
                $type,
                implode(', ', $allowed)
            ));
        }

        $this->type = $type;
    }

    public function addRecord(ZoneRecord $record)
    {
        $this->records[] = $record;
    }

    /**
     * @return ZoneRecord[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    public function getSecured(): bool
    {
        return $this->secured;
    }

    public function setSecured(bool $secured): void
    {
        $this->secured = $secured;
    }

    public function getSerializableFields(): array
    {
        return [
            'domain',
            // 'is_spamexperts_enabled',
            'master_ip' => 'ip',
            'records',
            'secured',
            // 'template_name' => 'name',
            'type',
        ];
    }

    public function propertyValueMap(): array
    {
        return [];
    }

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var Domain
     */
    private $domain = null;

    /**
     * @var string
     */
    private $type = self::TYPE_MASTER;

    /**
     * @var ZoneRecord
     */
    private $records = [];

    /**
     * Enable DNSSEC or not
     * @var bool
     */
    private $secured = true;
}
