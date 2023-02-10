<?php

namespace Openprovider\Entities\Base;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class Domain extends AbstractEntity
{

    /**
     * @var string
     */
    public $extension = '';

    /**
     * @var string
     */
    public $name = '';

    public function getSerializableFields(): array
    {
        return [
            'extension',
            'name'
        ];
    }

    public function propertyValueMap(): array
    {
        return [];
    }

    public function __toString()
    {
        return $this->name . '.' . $this->extension;
    }
}
