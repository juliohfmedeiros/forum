<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\TagManagement\Tag;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * DoctrineTagDescription
 *
 * @package App\Infrastructure\Persistence\Doctrine\TagManagement\Tag
 */
final class DoctrineTagDescription extends StringType
{

    /**
     * @inheritdoc
     *
     * @param string $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function getName()
    {
        return 'Description';
    }
}