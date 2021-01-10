<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\UserManagement\OAuth2;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;


/**
 * AuthTokenController
 *
 * @package App\UserInterface\UserManagement\OAuth2
 */
final class AuthTokenController  extends AbstractController
{
    /**
     * @var AuthorizationServer
     */
    private AuthorizationServer $server;

    /**
     * Creates a AuthTokenController
     *
     * @param AuthorizationServer $server
     */
    public function __construct(AuthorizationServer $server)
    {
        $this->server = $server;
    }

    /**
     * @Route("/auth/access-token")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $factory = new Psr17Factory();
        $psr7Factory = new PsrHttpFactory($factory, $factory, $factory, $factory);
        $httpFoundationFactory = new HttpFoundationFactory();

        $psrResponse = $psr7Factory->createResponse(new Response());
        try {
            $response = $this->server->respondToAccessTokenRequest(
                $psr7Factory->createRequest($request),
                $psrResponse
            );
        } catch (OAuthServerException $error) {
            return $httpFoundationFactory->createResponse($error->generateHttpResponse($psrResponse));
        } catch (Throwable $error) {
            return new Response(
                json_encode([
                    'error' => 'Internal Server Error',
                    'message' => $error->getMessage()
                ]),
                500,
                ['content-type' => 'application/json']
            );
        }

        return $httpFoundationFactory->createResponse($response);
    }
}
