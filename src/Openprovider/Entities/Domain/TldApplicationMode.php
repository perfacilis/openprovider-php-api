<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class TldApplicationMode extends AbstractEntity
{

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $title = '';

    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [];
    }
}
