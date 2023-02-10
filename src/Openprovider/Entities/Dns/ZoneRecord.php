<?php

namespace Openprovider\Entities\Dns;

use InvalidArgumentException;
use Openprovider\Entities\AbstractEntity;
use RuntimeException;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class ZoneRecord extends AbstractEntity
{

    /**
     * Types
     */
    const TYPE_A = 'A';
    const TYPE_AAAA = 'AAAA';
    const TYPE_CAA = 'CAA';
    const TYPE_CNAME = 'CNAME';
    const TYPE_MX = 'MX';
    // const TYPE_SPF = 'SPF'; // Deprecated
    const TYPE_SRV = 'SRV';
    const TYPE_TXT = 'TXT';
    const TYPE_NS = 'NS';
    const TYPE_TLSA = 'TLSA';
    const TYPE_SSHFP = 'SSHFP';
    const TYPE_SOA = 'SOA';

    /**
     * TTL in seconds
     */
    const TTL_15MIN = 900;
    const TTL_1HOUR = 3600;
    const TTL_3HOURS = 10800;
    const TTL_6HOURS = 21600;
    const TTL_12HOURS = 43200;
    const TTL_1DAY = 86400;

    /**
     * The DNS record types we don't want changed trough the API
     * @return array
     */
    public static function getReadonlyTypes(): array
    {
        return [
            self::TYPE_NS, self::TYPE_SOA
        ];
    }

    public static function getAllowedTypes(): array
    {
        return [
            self::TYPE_A, self::TYPE_AAAA, self::TYPE_CAA, self::TYPE_CNAME,
            self::TYPE_MX, self::TYPE_SRV, self::TYPE_TXT, self::TYPE_NS,
            self::TYPE_TLSA, self::TYPE_SSHFP, self::TYPE_SOA
        ];
    }

    public static function getAllowedTtls(): array
    {
        return [
            self::TTL_15MIN, self::TTL_1HOUR, self::TTL_3HOURS,
            self::TTL_6HOURS, self::TTL_12HOURS, self::TTL_1DAY
        ];
    }

    public static function getTypesWithPriority(): array
    {
        return [
            self::TYPE_MX, self::TYPE_SRV
        ];
    }

    public function getSerializableFields(): array
    {
        $fields = ['name', 'ttl', 'type', 'value'];

        if ($this->hasPrio()) {
            $fields[] = 'prio';
        }

        return $fields;
    }

    public function propertyValueMap(): array
    {
        return [];
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): void
    {
        $allowed = self::getAllowedTtls();
        if (!in_array($ttl, $allowed)) {
            throw new InvalidArgumentException(sprintf(
                'Given ttl \'%s\' is not valid, please use one of these: %s.',
                $ttl,
                implode(', ', $allowed)
            ));
        }

        $this->ttl = $ttl;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $allowed = self::getAllowedTypes();
        if (!in_array($type, $allowed)) {
            throw new InvalidArgumentException(sprintf(
                'Given type \'%s\' is not valid, please use any of these: %s.',
                $type,
                implode(',', $allowed)
            ));
        }

        $this->type = $type;
    }

    public function getPrio(): int
    {
        return $this->prio;
    }

    public function setPrio(int $prio): void
    {
        if ($this->hasPrio()) {
            $this->prio = $prio;
        }
    }

    public function hasPrio(): bool
    {
        if (!$this->type) {
            throw new RuntimeException('Record type has to be set before prio can be set or retrieved.');
        }

        $types_with_prio = self::getTypesWithPriority();
        return in_array($this->type, $types_with_prio);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        // Remove ending dot: "domain.tld." > "domain.tld"
        $value = rtrim($value, '.');

        // Ensure surrounding double quotes: 'foo' > '"foo"'
        if ($this->type === self::TYPE_TXT) {
            $value = '"' . trim($value, '"') . '"';
        }

        $this->value = $value;
    }

    public function getUid(): string
    {
        return md5($this->name . '|' . $this->type . '|' . $this->value . '|' . $this->prio);
    }

    /**
     * Read only records should not be changed trough API
     * @return bool
     */
    public function isReadonly(): bool
    {
        $readonly = self::getReadonlyTypes();
        return in_array($this->type, $readonly);
    }

    /**
     * @todo Make this named/zone file valid
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s IN %s + (%s)',
            $this->name ? $this->name : '@',
            $this->type,
            $this->hasPrio() ? $this->prio . ' ' . $this->value : $this->value
        );
    }

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var int
     */
    private $prio = 1;

    /**
     * @var int
     */
    private $ttl = self::TTL_1HOUR;

    /**
     * @var string
     */
    private $value = '';
}
