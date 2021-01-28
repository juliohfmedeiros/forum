<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\QuestionManagement;

use App\Application\CommandBus;
use App\Application\QuestionManagement\EditQuestionCommand;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EditQuestionController
 *
 * @package App\UserInterface\QuestionManagement
 */
final class EditQuestionController extends AbstractController implements AuthenticatedControllerInterface
{

    use ApiControllerMethods;
    use AuthenticatedControllerMethods;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * Creates a EditQuestionController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Handles edit question command
     *
     * @param Request $request
     * @return Response
     * @Route(path="/question/{questionId}", methods={"PUT", "PATCH"})
     */
    public function handle(Request $request, string $questionId): Response
    {
        try {
            $questionId = new QuestionId($questionId);
            $data = $this->parseRequest($request, ["title", "body"]);
            if (!$this->valid) {
                return $this->badRequest("Invalid or missing request data.");
            }

            $command = new EditQuestionCommand(
                $questionId,
                $data->title,
                $data->body
            );

            $question = $this->commandBus->handle($command);

        } catch (EntityNotFound $ex) {
            return $this->notFound($ex->getMessage());
        } catch (FailedEntitySpecification $ex) {
            return $this->preconditionFailed($ex->getMessage());
        } catch (InvalidUuidStringException $ex) {
            return $this->badRequest($ex->getMessage());
        }

        return new Response(json_encode($question), 200, ['content-type' => 'application/json']);

    }
}

/**
 * @OA\Put(
 *     path="/question/{questionId}",
 *     tags={"Questions"},
 *     summary="Edits the question with the provided question identifier",
 *     operationId="editQuestion",
 *     @OA\Response(
 *         response=400,
 *         description="Missing property or errors regarding data sent."
 *     ),
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="ID of question to edit",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=412,
 *         description="Trying to edit a question that isn't owned by the authenticated user or it's open."
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The question with changed values",
 *         @OA\JsonContent(ref="#/components/schemas/Question")
 *     ),
 *     @OA\RequestBody(
 *     request="EditQuestion",
 *         description="Object containing the new inforamtion needded to update the question stored with the privided identifier",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/EditQuestionCommand")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */
