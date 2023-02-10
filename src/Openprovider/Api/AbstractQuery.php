<?php

namespace Openprovider\Api;

use JsonSerializable;
use ReflectionClass;
use ReflectionProperty;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
abstract class AbstractQuery implements JsonSerializable
{
    public $offset = 0;
    public $limit = 100;

    public function __construct(array $params = [])
    {
        foreach ($params as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function getSerializableFields(): array
    {
        $ref = new ReflectionClass($this);
        $properties = $ref->getProperties(ReflectionProperty::IS_PUBLIC);

        $fields = [];
        foreach ($properties as $property) {
            $fields[] = $property->getName();
        }

        return $fields;
    }

    public function jsonSerialize(): array
    {
        $fields = $this->getSerializableFields();

        $values = [];
        foreach ($fields as $name) {
            $value = $this->{$name};
            if ($value !== null) {
                $values[$name] = $value;
            }
        }

        return $values;
    }
}
