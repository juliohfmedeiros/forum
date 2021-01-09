<?php

namespace App\Domain\UserManagement\OAuth2;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use Ramsey\Uuid\Uuid;


/**
 * AccessToken
 *
 * @package App\Domain\UserManagement\OAuth2
 *
 * @ORM\Entity()
 * @ORM\Table(name="access_tokens")
 */

class AccessToken implements AccessTokenEntityInterface
{
    /**
     * @var string
     *
     * @ORM\Id();
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $identifier;

    /**
     * @var ScopeEntityInterface[]
     *
     * @ORM\ManyToMany(targetEntity="App\Domain\UserManagement\OAuth2\Scope")
     * @ORM\JoinTable(name="token_scopes",
     *      joinColumns={@ORM\JoinColumn(name="token_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     *      )
     */
    protected $scopes = [];

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="expiry_date_time")
     */
    protected $expiryDateTime;

    /**
     * @var string|int|null
     *
     * @ORM\Column(type="UserId", name="user_identifier")
     */
    protected $userIdentifier;

    /**
     * @var ClientEntityInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\UserManagement\OAuth2\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    use EntityTrait, TokenEntityTrait, AccessTokenTrait;

    /**
     * Creates a AccessToken
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->identifier = Uuid::uuid4()->toString();
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes()
    {
        if (
            $this->scopes instanceof ArrayCollection ||
            $this->scopes instanceof PersistentCollection
        ) {
            $this->scopes = $this->scopes->toArray();
        }

        return array_values($this->scopes);
    }

}
