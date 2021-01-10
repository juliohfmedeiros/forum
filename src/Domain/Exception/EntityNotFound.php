<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Exception;

use App\Domain\DomainException;
use RuntimeException;

/**
 * EntityNotFound
 *
 * @package App\Domain\Exception
 */
final class EntityNotFound extends RuntimeException implements DomainException
{

}