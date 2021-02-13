<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\QuestionManagement;

use App\Application\CommandBus;
use App\Application\QuestionManagement\AddQuestionCommand;
use App\Application\UserManagement\OAuth2\CreateClientCommand;
use App\Domain\Exception\EntityNotFound;
use App\Domain\UserManagement\UserIdentifier;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * CreateAnswerController
 *
 * @package App\UserInterface\QuestionManagement
 */
final class CreateQuestionController extends AbstractController implements AuthenticatedControllerInterface
{

    use ApiControllerMethods;
    use AuthenticatedControllerMethods;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * Creates a CreateAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * Handles add new question command request
     *
     * @return Response
     * @Route(path="/questions", methods={"POST"})
     */
    public function handle(Request $request): Response
    {
        $user = $this->currentUser();
        $data = $this->parseRequest($request, ["title", "body"]);
        if (!$this->valid) {
            return $this->errorResponse;
        }

        $command = new AddQuestionCommand($user, $data->title, $data->body);

        try {
            $question = $this->commandBus->handle($command);
        } catch (EntityNotFound $ex) {
            return $this->notFound($ex->getMessage());
        }

        return new Response(json_encode($question), 200, ['content-type' => 'application/json']);
    }
}

/**
 * @OA\Post(
 *     path="/questions",
 *     tags={"Questions"},
 *     summary="Adds a new question for an authenticated user",
 *     operationId="addQuestion",
 *     @OA\Response(
 *         response=400,
 *         description="Missing property or errors regarding data sent."
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The newlly crated question",
 *         @OA\JsonContent(ref="#/components/schemas/Question")
 *     ),
 *     @OA\RequestBody(
 *     request="AddQuestion",
 *         description="Object containing the very minimal inforamtion needded to create a question",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/GiveQuestionCommand")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */
