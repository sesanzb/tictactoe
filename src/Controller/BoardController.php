<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Game;
use App\Entity\Marker;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path: '/board')]
class BoardController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {
        // dd($_SERVER);exit;
    }

    #[Route(path: '/', name: 'board_index')]
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('board/index.html.twig', [
            'controller_name' => 'BoardController',
        ]);
    }
    
    #[Route(path: '/{id}', name: 'board_show', methods: ['GET'])]
    public function show(Board $board): Response
    {
        return $this->render('board/show.html.twig', [
            'board' => $board,
        ]);
    }
        
    #[Route(path: '/{id}/add-marker/{row}-{col}', name: 'board_add_marker', methods: ['GET', 'POST'])]
    public function addMarker(Board $board, $row, $col): Response
    {
        $board_dimesion = $board->getDimension();
        if ($row < 0 || $row >= sqrt($board_dimesion) || $col < 0 || $col >= sqrt($board_dimesion)) {
            $this->addFlash('error', 'You cannot put a marker off the board!');
            return $this->redirectToRoute('homepage');
        }
        else if($board->getGame()->getEnddate() || $board->getMarkers()->count() == $board_dimesion) {
            $this->addFlash('error', 'Game is already over!');
            return $this->redirectToRoute('homepage');
        }
        else {
            $game = $board->getGame();
            $last_marker = $this->entityManager->getRepository(Game::class)->getLastMarkerPlayed($game);
            $marker_sign = (empty($last_marker->getSign()) || $last_marker->getSign() === Marker::CIRCLE_SIGN) ? Marker::CROSS_SIGN : Marker::CIRCLE_SIGN;
            $player = (empty($last_marker->getPlayer()) || $last_marker->getPlayer() === $game->getSecondPlayer()) ? $game->getFirstPlayer() : $game->getSecondPlayer();
            $marker = new Marker();
            $marker->setBoard($board)->setCol($col)->setRow($row)->setSign($marker_sign)->setPlayer($player);
            return $this->performAddMarker($board, $marker);
        }
    }

    private function performAddMarker(Board $board, Marker $marker) {
        try {
            $this->entityManager->persist($marker);
            $this->entityManager->flush();
            $board->addMarker($marker);
            $board_dimesion = $board->getDimension();
            if (($has_completed_line = $board->hasCompletedLines()) || $board->getMarkers()->count() === $board_dimesion) {
                return $this->redirectToRoute('game_finish', [
                        'id' => $board->getGame()->getId(),
                        'winner_id' => ($has_completed_line? $marker->getPlayer()->getId() : null),
                    ]);
            }
            return $this->redirectToRoute('homepage');
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash('error', 'There is already a marker placed in that box!');
            return $this->redirectToRoute('homepage');
        }
    }
}
