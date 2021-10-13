<?php

namespace App\Entity;

use App\Repository\BookLoanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookLoanRepository::class)
 */
class BookLoan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_loan;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_return;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="bookLoans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookLoans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_reserved;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_late;

    public function __construct(){
         $this->date_reserved = new \DateTime('now');
         $this->status = 'Réservé';
        $this->is_late = 0;
         return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLoan(): ?\DateTimeInterface
    {
        return $this->date_loan;
    }

    public function setDateLoan(\DateTimeInterface $date_loan): self
    {
        $this->date_loan = $date_loan;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->date_return;
    }

    public function setDateReturn(?\DateTimeInterface $date_return): self
    {
        $this->date_return = $date_return;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateReserved(): ?\DateTimeInterface
    {
        return $this->date_reserved;
    }

    public function setDateReserved(\DateTimeInterface $date_reserved): self
    {
        $this->date_reserved = $date_reserved;

        return $this;
    }

    public function getIsLate(): ?bool
    {
        return $this->is_late;
    }

    public function setIsLate(bool $is_late): self
    {
        $this->is_late = $is_late;

        return $this;
    }
}
