<?php

namespace App\Entity;

use App\DBAL\MarkerSignType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['board_id', 'row', 'col'])]
#[ORM\Entity(repositoryClass: 'App\Repository\MarkerRepository')]
#[ORM\Table(name: 'marker')]
#[UniqueConstraint(name: 'marker_position_uk', columns: ['board_id', 'row', 'col'])]
class Marker
{
    const CROSS_SIGN = MarkerSignType::CROSS_SIGN;
    const CIRCLE_SIGN = MarkerSignType::CIRCLE_SIGN;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint')]
    private $row;

    #[ORM\Column(type: 'smallint')]
    private $col;

    #[ORM\ManyToOne(targetEntity: 'Player')]
    #[ORM\JoinColumn(nullable: false)]
    private $player;

    #[ORM\Column(type: 'string', length: 1)]
    private $sign;

    #[ORM\ManyToOne(targetEntity: 'Board', inversedBy: 'markers')]
    #[ORM\JoinColumn(nullable: false)]
    private $board;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRow(int $row): self
    {
        $this->row = $row;

        return $this;
    }

    public function getCol(): ?int
    {
        return $this->col;
    }

    public function setCol(int $col): self
    {
        $this->col = $col;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getSign(): ?string
    {
        return $this->sign;
    }

    public function setSign($sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    public function getBoard(): ?Board
    {
        return $this->board;
    }

    public function setBoard(?Board $board): self
    {
        $this->board = $board;

        return $this;
    }
}
