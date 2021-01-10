<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\UserManagement\OAuth2;

use App\Domain\UserManagement\OAuth2\Client;
use App\Domain\UserManagement\OAuth2\ClientsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use RuntimeException;

/**
 * DoctrineClientsRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\UserManagement\OAuth2
 */
final class DoctrineClientsRepository implements ClientsRepository
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Creates a DoctrineClientsRepository
     *
     * @param EntityManagerInterface|EntityManager $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param null|string $grantType The grant type used (if sent)
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the client
     *                                        is confidential
     *
     * @return ClientEntityInterface
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function getClientEntity($clientIdentifier)
    {
        try {
            $client = $this->withId($clientIdentifier);
        } catch (RuntimeException $caught) {
            return null;
        }

        return $client;
    }

    /**
     * Adds a client to the repository
     *
     * @param Client $client
     * @return Client
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Client $client): Client
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
        return $client;
    }

    /**
     * Removes the client form this repository
     *
     * @param Client $client
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Client $client): void
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }

    /**
     * Retrieves the client with provided identifier
     *
     * @param string $identifier
     * @return Client
     *
     * @throws RuntimeException if a client is not found
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function withId(string $identifier): Client
    {
        $client = $this->entityManager->find(Client::class, $identifier);

        if (! $client instanceof Client) {
            throw new RuntimeException("Client not found.");
        }

        return $client;
    }

    /**
     * @inheritDoc
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        try {
            $client = $this->withId($clientIdentifier);
        } catch (RuntimeException $caught) {
            return false;
        }

        if ($clientSecret !== $client->secret()) {
            return false;
        }

        return true;
    }

}