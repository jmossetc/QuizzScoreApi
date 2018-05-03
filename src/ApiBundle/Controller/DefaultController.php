<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Friend;
use ApiBundle\Entity\Game;
use ApiBundle\Entity\Score;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\User;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig');
    }

    /**
     * @Route("api/create_game/{type}/{idUser}")
     */
    public function createGame($type, $idUser)
    {
        $em = $this->getDoctrine()->getManager();

        $score = new Score();
        $score->setIdPlayer($idUser);
        $score->setScore(0);
        $game = new Game();
        $game->setType($type);
        $game->addScore($score);

        $em->persist($game);
        $em->flush();

        return new JsonResponse([
            'idGame' => $game->getId()
        ]);
    }

    /**
     * @param $userId
     * @param $gameId
     *
     * @Route("api/add_user/{userId}/{gameId}")
     */
    public function addUser($userId, $gameId)
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);
        $em = $this->getDoctrine()->getManager();

        $game = $repository->find($gameId);
        $score = new Score();
        $score->setGame($game->getId());
        $score->setScore(0);
        $score->setIdPlayer($userId);
        $game->addScore($score);

        $em->persist($game);
        $em->flush();

        return new JsonResponse([
            'response' => 'OK'
        ]);
    }

    /**
     * @param $idGame
     *
     */
    /**
     * @param $idGame
     * @return JsonResponse
     *
     * @Route("api/get_scores/{idGame}")
     */
    public function getScores($idGame)
    {
        $repo = $this->getDoctrine()->getRepository(Game::class);
        $game = $repo->find($idGame);

        $scores = $game->getScores();
        $responseArray = [];

        foreach ($scores as $score) {
            $responseArray[$score->getIdPlayer()] = $score->getScore();
        }

        return new JsonResponse($responseArray);
    }

    /**
     * @param $idGame
     * @param $idPlayer
     * @return JsonResponse
     *
     * @Route("api/get_score/{idGame}/{idPlayer}")
     */
    public function getScore($idGame, $idPlayer)
    {
        $repo = $this->getDoctrine()->getRepository(Score::class);
        $score = $repo->getScore($idGame, $idPlayer);

        return new JsonResponse([
            $score->getScore()
        ]);
    }

    /**
     * @param $idGame
     * @param $idPlayer
     * @param $newScore
     * @return JsonResponse
     *
     * @Route("api/update_score/{idGame}/{idPlayer}/{newScore}")
     */
    public function updateScore($idGame, $idPlayer, $newScore)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository(Score::class);
        $score = $repo->getScore($idGame, $idPlayer);

        $score->setScore($newScore);
        $em->persist($score);
        $em->flush();

        return new JsonResponse([
            'response' => 'OK'
        ]);
    }

    /**
     * @param $idUser1
     * @param $idUser2
     * @return JsonResponse
     *
     * @Route("api/add_friend/{idUser1}/{idUser2}")
     */
    public function addFriend($idUser1, $idUser2)
    {
        $em = $this->getDoctrine()->getManager();

        $friend = new Friend();
        $friend->setIdUser1($idUser1);
        $friend->setIdUser2($idUser2);

        $em->persist($friend);
        $em->flush();

        return new JsonResponse([
            'response' => 'OK'
        ]);
    }


    /**
     * @param $idUser
     * @Route("api/get_friends/{idUser}")
     */
    public function getFriends($idUser)
    {
        $repo = $this->getDoctrine()->getRepository(Friend::class);

        $friends = $repo->getFriends($idUser);
        $friendsId = [];
        foreach ($friends as $friend) {
            if($friend->getIdUser1() != $idUser){
                $friendsId[] = $friend->getIduser1();
            }
            else if($friend->getIdUser2() != $idUser){
                $friendsId[] = $friend->getIduser2();
            }
        }

        return new JsonResponse($friendsId);
    }
}
