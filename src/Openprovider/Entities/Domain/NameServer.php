<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class NameServer extends AbstractEntity
{
    public $ip = '';
    public $ip6 = '';
    public $name = '';
    public $seq_nr = '';

    public function getSerializableFields(): array
    {
        return [
            'ip',
            'ip6',
            'name',
            'seq_nr'
        ];
    }

    public function propertyValueMap(): array
    {
        return [];
    }
}
