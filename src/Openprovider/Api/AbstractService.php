<?php

namespace Openprovider\Api;

use Openprovider\Api\Client;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
abstract class AbstractService
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create generator using list() method
     *
     * @param array $params Function arguments, offset and limit will be added
     * @return \Generator
     * @throws RuntimeException
     */
    protected function listAllGenerator(...$params): \Generator
    {
        if (!method_exists($this, 'list')) {
            throw new RuntimeException('Service must have a \'list\' method for listAll to work.');
        }

        $params['offset'] = 0;
        $params['limit'] = 100;

        while (true) {
            $batch = call_user_func_array([$this, 'list'], $params);
            foreach ($batch as $tld) {
                yield $tld;
            }

            if (count($batch) < $params['limit']) {
                break;
            }

            $params['offset'] += $params['limit'];
        }
    }

    /**
     * @var Client
     */
    protected $client = null;
}
