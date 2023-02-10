<?php

namespace Openprovider\Api\Billing;

use Openprovider\Api\AbstractQuery;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2021, Perfacilis
 */
class PaymentQuery extends AbstractQuery
{
    public $offset = 0;
    public $limit = 0;
    public $order = '';
    public $order_by = '';
    public $type = '';
    public $status = '';
    public $start_creation_date = '';
    public $end_creation_date = '';
}
