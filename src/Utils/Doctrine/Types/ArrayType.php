<?php

namespace App\Utils\Doctrine\Types;

use App\Utils\DTO\ArrayTypeSerializableDTO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ArrayType extends Type
{
    const ARRAY_TYPE = 'serializable_dto';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_decode($value, true);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof ArrayTypeSerializableDTO) {
            return null;
        }

        return json_encode($value->toArray());
    }

    public function getName(): string
    {
        return self::ARRAY_TYPE;
    }
}
