<?php

namespace App\Entity;

use App\Repository\MovimentacaoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovimentacaoRepository::class)]
class Movimentacao
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descricaomovimentacao = null;

    #[ORM\Column]
    private ?float $quantia = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\ManyToOne(inversedBy: 'movimentacaos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricaomovimentacao(): ?string
    {
        return $this->descricaomovimentacao;
    }

    public function setDescricaomovimentacao(string $descricaomovimentacao): self
    {
        $this->descricaomovimentacao = $descricaomovimentacao;

        return $this;
    }

    public function getQuantia(): ?float
    {
        return $this->quantia;
    }

    public function setQuantia(float $quantia): self
    {
        $this->quantia = $quantia;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}
