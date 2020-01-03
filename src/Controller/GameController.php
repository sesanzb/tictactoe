<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Game;
use App\Entity\Player;
use App\Form\GameType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="game_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->redirectToRoute('game_new');
    }

    /**
     * @Route("/new", name="game_new", methods={"GET","POST"})
     */
    public function new(Request $request, $modal = false): Response
    {
        $game = new Game();
        $game->setFirstPlayer(new Player());
        $game->setSecondPlayer(new Player());
        
        $form = $this->createForm(GameType::class, $game);   
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();
            $player1_nickname = $game->getFirstPlayer()->getNickname();
            $player2_nickname = $game->getSecondPlayer()->getNickname();
            if ($player1_nickname === $player2_nickname) {
                $this->addFlash('error', '¡Error initializing game: there can\'t be two players with the same nickname!');
                return $this->redirectToRoute('homepage');
            }
            
            return $this->init($player1_nickname,$player2_nickname);
        }
        
        return $this->render('game/new'.($modal? '-modal':'').'.html.twig', [
            'form' => $form->createView(),
            'class_prefix' => ($modal? 'modal-':'')
        ]);
    }

    /**
     * @Route("/{id}", name="game_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($game);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_index');
    }
    
    /**
     * @Route("/{id}/finish/{winner_id}", name="game_finish", defaults={"winner_id" = null}, methods={"GET","POST"})
     * @ParamConverter("game", options={"id" : "id"})
     * @ParamConverter("winner", options={"id" : "winner_id"})
     */
    public function finish(Game $game, Player $winner = null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $game->setEnddate(new DateTime("now"));
        $game->setWinner($winner);
        $entityManager->flush();
        return $this->redirectToRoute('homepage');
    }

    private function init($player1_nickname, $player2_nickname): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $playerRepository = $entityManager->getRepository(Player::class);
        $player1 = $playerRepository->findOneBy(['nickname' => $player1_nickname]) ?? new Player();
        $player2 = $playerRepository->findOneBy(['nickname' => $player2_nickname]) ?? new Player();
        $player1->setNickname($player1_nickname);
        $player2->setNickname($player2_nickname);
        $game = new Game();
        $game->setStartdate(new DateTime("now"));
        $board = new Board();
        $board->setDimension(9)
                ->setGame($game);
        $game->setBoard($board)
                ->setFirstPlayer($player1)
                ->setSecondPlayer($player2);
        $entityManager->persist($board);
        $entityManager->persist($game);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }

}
