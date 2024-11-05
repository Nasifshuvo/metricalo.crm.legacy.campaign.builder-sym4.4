<?php

declare(strict_types=1);

namespace App\Utils\DTO;

abstract class ArrayTypeSerializableDTO
{
    public function toArray(): array
    {
        $reflector = new \ReflectionClass($this);
        $properties = $reflector->getProperties();
        $array = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($this);
            $snakeCaseName = $this->camelToSnake($property->getName());
            $array[$snakeCaseName] = $value;
        }

        return $array;
    }

    /** @throws \ReflectionException */
    public static function fromArray(array $data)
    {
        $reflector = new \ReflectionClass(static::class);
        $dto = $reflector->newInstance();

        foreach ($data as $snakeCaseKey => $value) {
            $camelCaseProperty = self::snakeToCamel($snakeCaseKey);

            if ($reflector->hasProperty($camelCaseProperty)) {
                $property = $reflector->getProperty($camelCaseProperty);
                $property->setAccessible(true);
                $property->setValue($dto, $value);
            }
        }

        return $dto;
    }

    private function camelToSnake(string $input): string
    {
        return mb_strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($input)));
    }

    private static function snakeToCamel(string $input): string
    {
        return lcfirst(str_replace('_', '', ucwords($input, '_')));
    }
}
