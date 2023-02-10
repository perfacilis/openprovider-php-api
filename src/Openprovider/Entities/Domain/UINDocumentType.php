<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class UINDocumentType extends AbstractEntity
{
    public $description = '';
    public $doc_type = '';

    public function getSerializableFields(): array
    {
        return [
            'description',
            'doc_type',
        ];
    }

    public function propertyValueMap(): array
    {
        return [];
    }
}
