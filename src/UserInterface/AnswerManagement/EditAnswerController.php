<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\AnswerManagement;

use App\Application\CommandBus;
use App\Application\AnswerManagement\EditAnswerCommand;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EditAnswerController
 *
 * @package App\UserInterface\AnswerManagement
 */
final class EditAnswerController extends AbstractController implements AuthenticatedControllerInterface
{

    use ApiControllerMethods;
    use AuthenticatedControllerMethods;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * Creates a EditAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Handles edit answer command
     *
     * @param Request $request
     * @return Response
     * @Route(path="/answer/{answerId}", methods={"PUT", "PATCH"})
     */
    public function handle(Request $request, string $answerId): Response
    {
        try {
            $answerId = new AnswerId($answerId);
            $data = $this->parseRequest($request, ["title", "body"]);
            if (!$this->valid) {
                return $this->badRequest("Invalid or missing request data.");
            }

            $command = new EditAnswerCommand(
                $answerId,
                $data->description
            );

            $answer = $this->commandBus->handle($command);

        } catch (EntityNotFound $ex) {
            return $this->notFound($ex->getMessage());
        } catch (FailedEntitySpecification $ex) {
            return $this->preconditionFailed($ex->getMessage());
        } catch (InvalidUuidStringException $ex) {
            return $this->badRequest($ex->getMessage());
        }

        return new Response(json_encode($answer), 200, ['content-type' => 'application/json']);

    }
}

/**
 * @OA\Put(
 *     path="/answer/{answerId}",
 *     tags={"Answers"},
 *     summary="Edits the answer with the provided answer identifier",
 *     operationId="editAnswer",
 *     @OA\Response(
 *         response=400,
 *         description="Missing property or errors regarding data sent."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tag not found"
 *     ),
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to edit",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=412,
 *         description="Trying to edit a answer that isn't owned by the authenticated user or it's open."
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The answer with changed values",
 *         @OA\JsonContent(ref="#/components/schemas/Tag")
 *     ),
 *     @OA\RequestBody(
 *     request="EditAnswer",
 *         description="Object containing the new inforamtion needded to update the answer stored with the privided identifier",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/EditAnswerCommand")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */
