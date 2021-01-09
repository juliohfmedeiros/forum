<?php

namespace App\Domain\UserManagement\OAuth2;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Scope
 *
 * @package App\Domain\UserManagement\OAuth2
 *
 * @ORM\Entity()
 * @ORM\Table(name="scopes")
 */
class Scope implements ScopeEntityInterface
{
    /**
     * @var string
     *
     * @ORM\Id();
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * Creates a Scope
     *
     * @param string $identifier
     * @param string $description
     */
    public function __construct(string $identifier, string $description)
    {
        $this->identifier = $identifier;
        $this->description = $description;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * Get the scope's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Serialize the object to the scopes string identifier when using json_encode().
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
