<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * PagesController
 *
 * @package App\UserInterface
 */
final class PagesController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->redirect('/docs/index.html');
    }
}

/**
 * @OA\Info(
 *     title="Forum DAF",
 *     description="Este projecto visa criar uma API REST para desenvolvimento de um site ou aplicação de
suporte, num formato de pergunta e respostas.<br />
Tem como principal objectivo testar a capacidade do aluno criar uma aplicação web, com
Symfony 4 e usando os padrões lecionados nas aulas da disciplina de “desenvolvimento de
aplicações com frameworks.",
 *     version="v0.1.0",
 *     @OA\Contact(
 *          email="silvam.filipe@gmail.com"
 *     )
 * )
 */

/**
 * @OA\Tag(
 *     name="Questions",
 *     description="Questrions API endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User related endpoints"
 * )
 */

/**
 * @OA\SecurityScheme(
 *   securityScheme="OAuth2.0-Token",
 *   type="oauth2",
 *   @OA\Flow(
 *     tokenUrl="http://0.0.0.0:8080/auth/access-token",
 *     flow="password",
 *     scopes={}
 *   )
 * )
 */

/**
 * @OA\Schema(
 *     schema="DateTimeImmutable",
 *     title="DateTimeImmutable",
 *     type="object",
 *     @OA\Property(type="string", property="date", example="2019-07-07 00:00:00.000000"),
 *     @OA\Property(type="int", property="timezone_type", example=3),
 *     @OA\Property(type="string", property="timezone", example="UTC"),
 * )
 */

