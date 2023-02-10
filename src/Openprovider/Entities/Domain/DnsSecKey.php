<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class DnsSecKey extends AbstractEntity
{
    public $alg = 0;
    public $flags = 0;
    public $protocol = 0;
    public $pub_key = '';
    public $readonly = 0;

    public function getSerializableFields(): array
    {
        return [
            'alg',
            'flags',
            'protocol',
            'pub_key',
            'readonly',
        ];
    }

    public function propertyValueMap(): array
    {
        return [];
    }
}
