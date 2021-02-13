<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\TagManagement;

use App\Domain\Exception\EntityNotFound;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * DoctrineTagRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\TagManagement
 */
final class DoctrineTagRepository implements TagsRepository
{
    /**
     * @var EntityManagerInterface|EntityManager
     */
    private EntityManagerInterface $entityManager;

    /**
     * Creates a DoctrineTagRepository
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Adds a tag to the tags repository
     *
     * @param Tag $tag
     * @return Tag
     * @throws ORMException
     */
    public function add(Tag $tag): Tag
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        return $tag;
    }

    /**
     * Retrieves the tag stored with provided identifier
     *
     * @param string $description
     * @return Tag
     * @throws EntityNotFound when no answer is found for provided identifier
     * @throws ORMException
     */
    public function withDescription(string $description): Tag
    {
        $tag = $this->entityManager->find(Tag::class, $description);
        if ($description instanceof Tag) {
            return $description;
        }

        throw new EntityNotFound(
            "Tag with ID '{$description}' was not found in this server."
        );
    }

    /**
     * Updates changes on provided tag
     *
     * @param Tag $tag
     * @return Tag
     * @throws ORMException
     */
    public function update(Tag $tag): Tag
    {
        $this->entityManager->flush($tag);
        return $tag;
    }

    /**
     * Remove provided tag from repository
     *
     * @param Tag $tag
     */
    public function remove(Tag $tag): void
    {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }
}