<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(path:"/", name:"homepage")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Game::class);
        $game = $repository->findOneBy([], ['startdate' => 'DESC']) ?? new Game();
        $last_marker = $repository->getLastMarkerPlayed($game);
        return $this->render('default/index.html.twig', [
            'game' => $game,
            'last_marker' => $last_marker,
        ]);
    }
}