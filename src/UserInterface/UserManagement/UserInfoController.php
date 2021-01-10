<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\UserManagement;

use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * UserInfoController
 *
 * @package App\UserInterface\UserManagement
 */
final class UserInfoController extends AbstractController implements AuthenticatedControllerInterface
{
    use AuthenticatedControllerMethods;

    /**
     * @return Response
     *
     * @Route("/users/me")
     */
    public function info()
    {
        return new Response(json_encode($this->currentUser()), 200, ['content-type' => 'application/json']);
    }
}

/**
 * @OA\Get(
 *     path="/users/me",
 *     operationId="userInfo",
 *     summary="Current user information",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Current user information",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/User")
 *         )
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 *
 * )
 */
