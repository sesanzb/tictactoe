<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\GameRepository')]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Player', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $first_player;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Player', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $second_player;

     #[ORM\ManyToOne(targetEntity: 'App\Entity\Player')]
    private $winner;
    
    #[ORM\Column(type: 'datetime')]
    private $startdate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $enddate;

    #[ORM\OneToOne(targetEntity: 'App\Entity\Board', mappedBy: 'game', cascade: ['persist', 'remove'])]
    private $board;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getFirstPlayer(): ?Player
    {
        return $this->first_player;
    }

    public function setFirstPlayer(?Player $first_player): self
    {
        $this->first_player = $first_player;

        return $this;
    }

    public function getSecondPlayer(): ?Player
    {
        return $this->second_player;
    }

    public function setSecondPlayer(?Player $second_player): self
    {
        $this->second_player = $second_player;

        return $this;
    }
    
    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(?\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getBoard(): ?Board
    {
        return $this->board;
    }

    public function setBoard(Board $board): self
    {
        $this->board = $board;

        // set the owning side of the relation if necessary
        if ($board->getGame() !== $this) {
            $board->setGame($this);
        }

        return $this;
    }
}
