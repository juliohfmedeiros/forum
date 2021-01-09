<?php

namespace App\Domain\UserManagement\OAuth2;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Ramsey\Uuid\Uuid;

/**
 * RefreshToken
 *
 * @package App\Domain\UserManagement\OAuth2
 *
 * @ORM\Entity()
 * @ORM\Table(name="refresh_tokens")
 */
class RefreshToken implements RefreshTokenEntityInterface
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
     * @var AccessTokenEntityInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\UserManagement\OAuth2\AccessToken", cascade={"remove"})
     * @ORM\JoinColumn(name="access_token_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $accessToken;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="expiry_date_time")
     */
    protected $expiryDateTime;

    use EntityTrait, RefreshTokenTrait;

    /**
     * Creates a RefreshToken
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->identifier = Uuid::uuid4()->toString();
    }
}

