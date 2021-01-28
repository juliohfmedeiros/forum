<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\QuestionManagement;

use App\Domain\Exception\EntityNotFound;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ReadQuestionController
 *
 * @package App\UserInterface\QuestionManagement
 */
final class ReadQuestionController extends AbstractController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods;
    use ApiControllerMethods;

    /**
     * @var QuestionsRepository
     */
    private QuestionsRepository $questionsRepository;

    /**
     * Creates a ReadQuestionController
     *
     * @param QuestionsRepository $questionsRepository
     */
    public function __construct(QuestionsRepository $questionsRepository)
    {
        $this->questionsRepository = $questionsRepository;
    }

    /**
     * Read a question stored with provided question ID
     *
     * @param string $questionId Injected question identifier from route path
     * @return Response
     * @Route(path="/question/{questionId}", methods={"GET"})
     */
    public function read(string $questionId): Response
    {
        try {
            $questionId = new QuestionId($questionId);
            $question = $this->questionsRepository->withId($questionId);
        } catch (EntityNotFound $ex) {
            return $this->notFound($ex->getMessage());
        } catch (InvalidUuidStringException $ex) {
            return $this->badRequest($ex->getMessage());
        }

        return new Response(json_encode($question), 200, ['content-type' => 'application/json']);
    }
}

/**
 * @OA\Get(
 *     path="/question/{questionId}",
 *     tags={"Questions"},
 *     summary="Retrieves the question stored with provided question identifier",
 *     operationId="readQuestion",
 *     @OA\Response(
 *         response=400,
 *         description="Invalid question identifier"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Quesiton not found"
 *     ),
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="ID of question to retrieve",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The question with stored with provided identifier",
 *         @OA\JsonContent(ref="#/components/schemas/Question")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */
