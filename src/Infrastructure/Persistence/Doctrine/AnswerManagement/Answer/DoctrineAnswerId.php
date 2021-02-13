<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\AnswerManagement\Answer;

use App\Domain\AnswerManagement\Answer\AnswerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * DoctrineAnswerId
 *
 * @package App\Infrastructure\Persistence\Doctrine\AnswerManagement\Tag
 */
final class DoctrineAnswerId extends StringType
{

    /**
     * @inheritdoc
     *
     * @param AnswerId $value
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
        return new AnswerId($value);
    }

    public function getName()
    {
        return 'AnswerId';
    }
}