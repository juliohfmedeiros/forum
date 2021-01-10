<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\UserManagement\OAuth2;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * ClientRepository
 *
 * @package App\Domain\UserManagement\OAuth2
 */
interface ClientsRepository extends ClientRepositoryInterface
{

    /**
     * Adds a client to the repository
     *
     * @param Client $client
     * @return Client
     */
    public function add(Client $client): Client;

    /**
     * Removes the client form this repository
     *
     * @param Client $client
     */
    public function remove(Client $client): void;

    /**
     * Retrieves the client with provided identifier
     *
     * @param string $identifier
     * @return Client
     *
     * @throws \RuntimeException if a client is not found
     */
    public function withId(string $identifier): Client;
}
