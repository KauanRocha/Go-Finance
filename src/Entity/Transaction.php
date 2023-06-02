<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("api_list")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("api_list")]
    private ?string $descricao = null;

    #[ORM\Column]
    #[Groups("api_list")]
    private ?float $valor = null;

    #[ORM\Column]
    #[Groups("api_list")]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("api_list")]
    private ?\DateTimeInterface $data = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: "create")]
    #[Groups("api_list")]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: "update")]
    #[Groups("api_list")]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups("api_list")]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[Groups("api_list")]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[Groups("api_list")]
    private ?User $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

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

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }



    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }


    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
