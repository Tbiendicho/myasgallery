<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArtworkRepository::class)
 * @Vich\Uploadable
 */
class Artwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"api_artwork_browse", "api_artists_browse", "api_event_browse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_artwork_browse", "api_artists_browse", "api_event_browse"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"api_artwork_browse", "api_artists_browse", "api_event_browse"})
     */
    private $height;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"api_artwork_browse", "api_artists_browse", "api_event_browse"})
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"api_artwork_browse", "api_artists_browse", "api_event_browse"})
     */
    private $depth;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     * 
     * @Groups({"api_artwork_browse", "api_artists_browse", "api_event_browse"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     * 
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="artworks")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"api_artwork_browse", "api_event_browse"})
     */
    private $artists;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="artworks", fetch="EAGER")
     * 
     * @Groups({"api_artwork_browse"})
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="artworks", fetch="EAGER")
     * 
     * @Groups({"api_artwork_browse", "api_artists_browse"})
     */
    private $events;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pictureSize;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="artworks_img", fileNameProperty="pictureName", size="pictureSize")
     */
    private $picture;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->events = new ArrayCollection();


        // adding a new date for each new object, corresponding to the flush date
        $this->createdAt = new DateTimeImmutable();
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

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getDepth(): ?int
    {
        return $this->depth;
    }

    public function setDepth(?int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getArtists(): ?Artist
    {
        return $this->artists;
    }

    public function setArtists(?Artist $artists): self
    {
        $this->artists = $artists;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(?string $pictureName): void
    {
        $this->pictureName = $pictureName;
    }

    public function getPictureSize(): ?int
    {
        return $this->pictureSize;
    }

    public function setPictureSize(?int $pictureSize): void
    {
        $this->pictureSize = $pictureSize;
    }

    public function getPicture(): ?File
    {
        return $this->picture;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $picture
     */
    public function setPicture(?File $picture = null): void
    {
        $this->picture = $picture;

        if (null !== $picture) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
}
