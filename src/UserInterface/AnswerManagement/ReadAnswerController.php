<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\AnswerManagement;

use App\Domain\AnswerManagement\AnswersRepository;
use App\Domain\Exception\EntityNotFound;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\Domain\AnswerManagement\Answer;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ReadAnswerController
 *
 * @package App\UserInterface\AnswerManagement
 */
final class ReadAnswerController extends AbstractController implements AuthenticatedControllerInterface
{

    use AuthenticatedControllerMethods;
    use ApiControllerMethods;

    /**
     * @var AnswersRepository
     */
    private AnswersRepository $answersRepository;

    /**
     * Creates a ReadAnswerController
     *
     * @param AnswersRepository $answersRepository
     */
    public function __construct(AnswersRepository $answersRepository)
    {
        $this->answersRepository = $answersRepository;
    }

    /**
     * Read a answer stored with provided answer ID
     *
     * @param string $answerId Injected answer identifier from route path
     * @return Response
     * @Route(path="/answer/{answerId}", methods={"GET"})
     */
    public function read(string $answerId): Response
    {
        try {
            $answerId = new AnswerId($answerId);
            $answer = $this->answersRepository->withId($answerId);
        } catch (EntityNotFound $ex) {
            return $this->notFound($ex->getMessage());
        } catch (InvalidUuidStringException $ex) {
            return $this->badRequest($ex->getMessage());
        }

        return new Response(json_encode($answer), 200, ['content-type' => 'application/json']);
    }
}

/**
 * @OA\Get(
 *     path="/answer/{answerId}",
 *     tags={"Answers"},
 *     summary="Retrieves the answer stored with provided answer identifier",
 *     operationId="readAnswer",
 *     @OA\Response(
 *         response=400,
 *         description="Invalid answer identifier"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Quesiton not found"
 *     ),
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="ID of answer to retrieve",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The answer with stored with provided identifier",
 *         @OA\JsonContent(ref="#/components/schemas/Tag")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */
