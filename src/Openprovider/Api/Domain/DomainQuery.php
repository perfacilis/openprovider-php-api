<?php

namespace Openprovider\Api\Domain;

use Openprovider\Api\AbstractQuery;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class DomainQuery extends AbstractQuery
{
    public $domain_name_patten = '';
    public $full_name = '';
    public $with_history = false;
    public $with_api_history = false;
    public $with_additional_data = false;
    public $with_verification_email = false;
    public $with_registry_statuses = false;
}
