<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question\QuestionId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * DoctrineQuestionId
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question
 */
final class DoctrineQuestionId extends StringType
{

    /**
     * @inheritdoc
     *
     * @param QuestionId $value
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
        return new QuestionId($value);
    }

    public function getName()
    {
        return 'QuestionId';
    }
}