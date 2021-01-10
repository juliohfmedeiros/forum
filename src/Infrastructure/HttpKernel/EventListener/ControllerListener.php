<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\HttpKernel\EventListener;

use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\Domain\UserManagement\User\UserId;
use App\Domain\UserManagement\UserIdentifier;
use App\Domain\UserManagement\UsersRepository;
use App\Infrastructure\HttpKernel\Oauth2Exception;
use Exception;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpKernel\Event\ControllerEvent;


/**
 * ControllerListener
 *
 * @package App\Infrastructure\HttpKernel\EventListener
 */
final class ControllerListener
{

    /**
     * @var ResourceServer
     */
    private ResourceServer $resourceServer;
    /**
     * @var UsersRepository
     */
    private UsersRepository $users;
    /**
     * @var UserIdentifier
     */
    private UserIdentifier $identifier;

    /**
     * ControllerListener
     *
     * @param ResourceServer $resourceServer
     * @param UsersRepository $users
     * @param UserIdentifier $identifier
     */
    public function __construct(ResourceServer $resourceServer, UsersRepository $users, UserIdentifier $identifier)
    {
        $this->resourceServer = $resourceServer;
        $this->users = $users;
        $this->identifier = $identifier;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController()[0];

        if (! $controller instanceof AuthenticatedControllerInterface) {
            return null;
        }

        $factory = new Psr17Factory();
        $psr7Factory = new PsrHttpFactory($factory, $factory, $factory, $factory);
        $httpFoundationFactory = new HttpFoundationFactory();

        try {
            $request = $this->resourceServer->validateAuthenticatedRequest($psr7Factory->createRequest($event->getRequest()));
            $this->loadUser($request->getAttribute('oauth_user_id', null), $controller);
        } catch (OAuthServerException $e) {
            $event->stopPropagation();
            $response = $e->generateHttpResponse(new Response());
            $exception = new Oauth2Exception("OAuth 2.0 error");
            throw $exception->withResponse($httpFoundationFactory->createResponse($response));
        }

        return null;
    }

    /**
     * @param string $getUserAttribute
     * @param AuthenticatedControllerInterface $controller
     * @throws Exception
     */
    private function loadUser(string $getUserAttribute, AuthenticatedControllerInterface $controller)
    {
        $user = $this->users->withUserId(new UserId($getUserAttribute));
        $controller->withCurrentUser($user);
        $this->identifier->withUser($user);
    }

}