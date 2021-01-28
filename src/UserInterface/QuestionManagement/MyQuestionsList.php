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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MyQuestionsList
 *
 * @package App\UserInterface\QuestionManagement
 */
final class MyQuestionsList extends AbstractController
{

    use ApiControllerMethods;

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
    public function handle(): Response
    {
        return new Response(
            json_encode($this->questionsList->data()),
            200,
            ["content-type" => "application/json"]
        );
    }
}