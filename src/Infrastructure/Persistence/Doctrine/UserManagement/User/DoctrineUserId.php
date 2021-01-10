<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\UserManagement\User;

use App\Domain\UserManagement\User\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * DoctrineUserId
 *
 * @package App\Infrastructure\Persistence\Doctrine\UserManagement\User
 */
final class DoctrineUserId extends StringType
{

    /**
     * @inheritdoc
     *
     * @param UserId $value
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
        return new UserId($value);
    }

    public function getName()
    {
        return 'UserId';
    }
}
