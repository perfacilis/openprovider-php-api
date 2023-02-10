<?php

namespace Openprovider\Entities;

use JsonSerializable;
use RuntimeException;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
abstract class AbstractEntity implements JsonSerializable
{

    /**
     * Array map export name => internal name
     * Or internal name only, if the same
     */
    abstract public function getSerializableFields(): array;

    /**
     * Map propery names to constructor class names before setter/getter is called
     * @param string Property name
     * @return array ['property' => className];
     */
    abstract public function propertyValueMap(): array;

    public function __construct(array $values = [])
    {
        $property_value_map = $this->propertyValueMap();
        foreach ($values as $field => $value) {
            if (isset($property_value_map[$field])) {
                $value = new $property_value_map[$field]($value);
            }

            $this->setPropertyValue($field, $value);
        }
    }

    public function jsonSerialize(): array
    {
        $array = [];
        foreach ($this->getSerializableFields() as $export_as => $fieldname) {
            if (is_numeric($export_as)) {
                $export_as = $fieldname;
            }

            $value = $this->getPropertyValue($fieldname);
            $array[$export_as] = $this->formatValue($value);
        }

        return $array;
    }

    private static function studlyCaps(string $string): string
    {
        $string = strtolower($string);
        $string = trim(preg_replace('~[^a-z0-9]+~', ' ', $string));
        return str_replace(' ', '', ucwords($string));
    }

    private function getPropertyValue(string $property)
    {
        if (!property_exists($this, $property)) {
            throw new RuntimeException(sprintf('Given field \'%s\' is not a readble field.', $property));
        }

        // Use getter
        $getter = 'get' . self::studlyCaps($property);
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        return $this->{$property};
    }

    private function setPropertyValue(string $property, $value): void
    {
        $setter = 'set' . self::studlyCaps($property);
        if (method_exists($this, $setter)) {
            $this->{$setter}($value);
            return;
        }

        if (property_exists($this, $property)) {
            $this->{$property} = $value;
            return;
        }
    }

    private function formatValue($value)
    {
        switch (gettype($value)) {
            case 'array':
                return $this->formatArrayValue($value);
            // nobreak;

            case 'object':
                return $value->jsonSerialize();
            // nobreak;
        }

        return $value;
    }

    private function formatArrayValue(array $value): array
    {
        $ret = [];
        foreach ($value as $item) {
            $ret[] = $this->formatValue($item);
        }

        return $ret;
    }
}
