<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Vich\Uploadable
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $img_cover;

    /**
     * @Vich\UploadableField(mapping="book_covers", fileNameProperty="img_cover")
     * @var File
     */
    private $folderImage;

    /**
     * @ORM\Column(type="datetime",  options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="date")
     */
    private $published_at;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_reserved;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_favorite;

    /**
     * @ORM\ManyToMany(targetEntity=Type::class, inversedBy="books", cascade={"persist"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=BookLoan::class, mappedBy="book")
     */
    private $bookLoans;

    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->bookLoans = new ArrayCollection();
        $this->is_reserved = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImgCover(): ?string
    {
        return $this->img_cover;
    }

    public function setImgCover( ?string $img_cover): self
    {
        $this->img_cover = $img_cover;

        return $this;
    }


    /**
     * @return null|File
     */
    public function getFolderImage(): ?File
    {
        return $this->folderImage;
    }

    /**
     * @param File|null $folderImage
     */

    public function setFolderImage(?File $folderImage = null): void
    {
        $this->folderImage = $folderImage;

        if($folderImage){
            $this->updated_at = new \DateTime('now');
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsReserved(): ?bool
    {
        return $this->is_reserved;
    }

    public function setIsReserved(bool $is_reserved): self
    {
        $this->is_reserved = $is_reserved;

        return $this;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->is_favorite;
    }

    public function setIsFavorite(bool $is_favorite): self
    {
        $this->is_favorite = $is_favorite;

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->type->removeElement($type);

        return $this;
    }

    /**
     * @return Collection|BookLoan[]
     */
    public function getBookLoans(): Collection
    {
        return $this->bookLoans;
    }

    public function addBookLoan(BookLoan $bookLoan): self
    {
        if (!$this->bookLoans->contains($bookLoan)) {
            $this->bookLoans[] = $bookLoan;
            $bookLoan->setBook($this);
        }

        return $this;
    }

    public function removeBookLoan(BookLoan $bookLoan): self
    {
        if ($this->bookLoans->removeElement($bookLoan)) {
            // set the owning side to null (unless already changed)
            if ($bookLoan->getBook() === $this) {
                $bookLoan->setBook(null);
            }
        }

        return $this;
    }
}
