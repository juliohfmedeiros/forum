<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\QuestionManagement;

use App\Application\QuestionManagement\QuestionsListQuery;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MyQuestionsList
 *
 * @package App\UserInterface\QuestionManagement
 */
final class MyQuestionsList extends AbstractController implements AuthenticatedControllerInterface
{

    use ApiControllerMethods;

    use AuthenticatedControllerMethods;

    /**
     * @var QuestionsListQuery
     */
    private QuestionsListQuery $questionsList;

    /**
     * Creates a MyQuestionsList
     *
     * @param QuestionsListQuery $questionsList
     */
    public function __construct(QuestionsListQuery $questionsList)
    {
        $this->questionsList = $questionsList;
    }

    /**
     * handle
     *
     * @return Response
     * @Route(path="/questions", methods={"GET"})
     */
    public function handle(Request $request): Response
    {
        return new Response(
            json_encode($this->questionsList->data([
                "ownerId" => $this->currentUser()->userId(),
                "page" => $request->query->get('page', 1),
                "rows" => $request->query->get('rows', 10),
                "pattern" => $request->query->get('pattern', null)
            ])),
            200,
            ["content-type" => "application/json"]
        );
    }
}

/**
 * @OA\Get(
 *     path="/questions",
 *     tags={"Questions"},
 *     summary="Lists the questions of current logged in user",
 *     operationId="readMyQuestions",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Start page",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="rows",
 *         in="query",
 *         description="Number of rows per page",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="pattern",
 *         in="query",
 *         description="Filters result with a search pattern",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="A list of user questions",
 *         @OA\JsonContent(ref="#/components/schemas/QuestionList")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ListingQuestion",
 *     title="Listing Question",
 *     type="object",
 *     @OA\Property(property="questionId", type="string", example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"),
 *     @OA\Property(property="title", type="string", example="What time is it in Boston?"),
 *     @OA\Property(property="body", type="string", example="A longer consideration on how to ask for current time in Boston."),
 *     @OA\Property(property="open", type="boolean", example=false),
 *     @OA\Property(property="ownerId", type="string", example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"),
 *     @OA\Property(property="appliedOn", type="string", example="021-01-27 15:59:01"),
 *     @OA\Property(property="ownerName", type="string", example="John Doe"),
 *     @OA\Property(property="ownerEmail", type="string", example="john.doe@example.com"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="QuestionList",
 *     type="object",
 *     @OA\Property(
 *          property="attributes",
 *          type="object",
 *          @OA\AdditionalProperties(
 *              type="string"
 *          )
 *     ),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ListingQuestion")),
 *     @OA\Property(property="count", type="integer", example=32),
 *     @OA\Property(property="isEmpty", type="bool", example=false),
 * )
 */
