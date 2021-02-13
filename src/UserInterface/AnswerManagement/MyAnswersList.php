<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\AnswerManagement;

use App\Application\AnswerManagement\AnswersListQuery;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MyAnswersList
 *
 * @package App\UserInterface\AnswerManagement
 */
final class MyAnswersList extends AbstractController implements AuthenticatedControllerInterface
{

    use ApiControllerMethods;

    use AuthenticatedControllerMethods;

    /**
     * @var AnswersListQuery
     */
    private AnswersListQuery $answersList;

    /**
     * Creates a MyAnswersList
     *
     * @param AnswersListQuery $answersList
     */
    public function __construct(AnswersListQuery $answersList)
    {
        $this->answersList = $answersList;
    }

    /**
     * handle
     *
     * @return Response
     * @Route(path="/answers", methods={"GET"})
     */
    public function handle(Request $request): Response
    {
        return new Response(
            json_encode($this->answersList->data([
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
 *     path="/answers",
 *     tags={"Answers"},
 *     summary="Lists the answers of current logged in user",
 *     operationId="readMyAnswers",
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
 *         description="A list of user answers",
 *         @OA\JsonContent(ref="#/components/schemas/AnswerList")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {"user.management"}}
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ListingAnswer",
 *     title="Listing Tag",
 *     type="object",
 *     @OA\Property(property="answerId", type="string", example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"),
 *     @OA\Property(property="description", type="string", example="A longer consideration on how to ask for current time in Boston."),
 *     @OA\Property(property="accepted", type="boolean", example=false),
 *     @OA\Property(property="ownerId", type="string", example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"),
 *     @OA\Property(property="givenOn", type="string", example="021-01-27 15:59:01"),
 *     @OA\Property(property="ownerName", type="string", example="John Doe"),
 *     @OA\Property(property="ownerEmail", type="string", example="john.doe@example.com"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="AnswerList",
 *     type="object",
 *     @OA\Property(
 *          property="attributes",
 *          type="object",
 *          @OA\AdditionalProperties(
 *              type="string"
 *          )
 *     ),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ListingAnswers")),
 *     @OA\Property(property="count", type="integer", example=32),
 *     @OA\Property(property="isEmpty", type="bool", example=false),
 * )
 */
