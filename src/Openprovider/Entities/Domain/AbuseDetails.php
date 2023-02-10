<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class AbuseDetails extends AbstractEntity
{
    public $abuse_id = 0;
    public $is_domain_held = false;
    public $message = '';

    public function getSerializableFields(): array
    {
        return [];
    }

    public function propertyValueMap(): array
    {
        return [];
    }
}
