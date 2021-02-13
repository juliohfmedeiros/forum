<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\TagManagement;

use App\Domain\TagManagement\Tag;
use App\Domain\Exception\EntityNotFound;

/**
 * TagsRepository
 *
 * @package App\Domain\TagManagement
 */
interface TagsRepository
{

    /**
     * Adds a tag to a question in repository
     *
     * @param Tag $tag
     * @return Tag
     */
    public function add(Tag $tag): Tag;

    /**
     * Retrieves the tags stored with provided identifier
     *
     * @param string $description
     * @return Tag
     * @throws EntityNotFound when no tag is found for provided identifier
     */
    public function withDescription(string $description): Tag;

    /**
     * Updates changes on provided tag
     *
     * @param Tag $tag
     * @return Tag
     */
    public function update(Tag $tag): Tag;

    /**
     * Remove provided tag from repository
     *
     * @param Tag $tag
     */
    public function remove(Tag $tag): void;

}
