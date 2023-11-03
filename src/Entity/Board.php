<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Array_;

#[ORM\Entity(repositoryClass: 'App\Repository\BoardRepository')]
class Board
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: 'App\Entity\Game', inversedBy: 'board', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $game;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Marker', mappedBy: 'board', orphanRemoval: true)]
    private $markers;

    #[ORM\Column(type: 'smallint')]
    private $dimension;

    public function __construct()
    {
        $this->markers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getMarkers(): Collection
    {
        return $this->markers;
    }

    public function addMarker(Marker $marker): self
    {
        if (!$this->markers->contains($marker)) {
            $this->markers[] = $marker;
            $marker->setBoard($this);
        }

        return $this;
    }

    public function removeMarker(Marker $marker): self
    {
        if ($this->markers->contains($marker)) {
            $this->markers->removeElement($marker);
            // set the owning side to null (unless already changed)
            if ($marker->getBoard() === $this) {
                $marker->setBoard(null);
            }
        }

        return $this;
    }

    public function getDimension(): ?int
    {
        return $this->dimension;
    }

    public function setDimension(int $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }
    
    /**
     * @return [][]
     */
    public function getMarkersMatrix(): array
    {
        $matrix = array_fill(0, sqrt($this->dimension), array_fill(0, sqrt($this->dimension), NULL));
        
        foreach ($this->markers as $marker) {
            $matrix[$marker->getRow()][$marker->getCol()] = $marker->getSign();
        }
        
        return $matrix;
    }
    
    public function hasCompletedLines() : bool
    {
        $matrix = $this->getMarkersMatrix();
        return $this->hasCompletedRows($matrix) || $this->hasCompletedColums($matrix) || $this->hasCompletedDiagonals($matrix);
    }
    
    private function hasCompletedRows(array $matrix) : bool
    {
        for ($row = 0; $row < count($matrix); $row++) {
            if ( !in_array(null, $matrix[$row], true) && max(array_count_values($matrix[$row])) === count($matrix)) {
                return true;
            }
        }
        return false;
    }
    
    private function hasCompletedColums(array $matrix) : bool
    {
        //We transpose matrix and check rows
        array_unshift($matrix, null);
        $transpose = call_user_func_array('array_map', $matrix);
        for ($row = 0; $row < count($transpose); $row++) {
            if (!in_array(null, $transpose[$row], true) && max(array_count_values($transpose[$row])) === count($transpose)) {
                return true;
            }
        }
        return false;
    }
    
    private function hasCompletedDiagonals(array $matrix) : bool
    {
        $diagonals_matrix = array();
        for ($i = 0; $i < count($matrix); $i++) {
            $diagonals_matrix [0][$i] = $matrix[$i][$i];
            $diagonals_matrix [1][$i] = $matrix[$i][count($matrix) - $i - 1]; 
        }
                
        return ((!in_array(null, $diagonals_matrix[0], true) && max(array_count_values($diagonals_matrix[0]))=== count($matrix)) ||
                (!in_array(null, $diagonals_matrix[1], true) && max(array_count_values($diagonals_matrix[1]))=== count($matrix)));
    }     
}
