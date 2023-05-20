<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $descricaocategoria = null;

    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Movimentacao::class)]
    private Collection $movimentacaos;

    public function __construct()
    {
        $this->movimentacaos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getdescricaocategoria(): ?string
    {
        return $this->descricaocategoria;
    }

    public function setdescricaocategoria(string $descricaocategoria): self
    {
        $this->descricaocategoria = $descricaocategoria;

        return $this;
    }

    /**
     * @return Collection<int, Movimentacao>
     */
    public function getMovimentacaos(): Collection
    {
        return $this->movimentacaos;
    }

    public function addMovimentacao(Movimentacao $movimentacao): self
    {
        if (!$this->movimentacaos->contains($movimentacao)) {
            $this->movimentacaos->add($movimentacao);
            $movimentacao->setCategoria($this);
        }

        return $this;
    }

    public function removeMovimentacao(Movimentacao $movimentacao): self
    {
        if ($this->movimentacaos->removeElement($movimentacao)) {
            // set the owning side to null (unless already changed)
            if ($movimentacao->getCategoria() === $this) {
                $movimentacao->setCategoria(null);
            }
        }

        return $this;
    }
}
