<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $information;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $link;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=8, nullable=true)
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=8, nullable=true)
     * 
     * @Groups({"api_event_browse", "api_artwork_browse", "api_artists_browse"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $roadNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roadName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $roadName2;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Artwork::class, mappedBy="events", fetch="EAGER", cascade={"persist"})
     * 
     * @Groups({"api_event_browse"})
     */
    private $artworks;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="events")
     */
    private $artists;

    public function __construct()
    {
        $this->artworks = new ArrayCollection();
        $this->artists = new ArrayCollection();

        // adding a new date for each new object, corresponding to the flush date
        $this->createdAt = new DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getRoadNumber(): ?int
    {
        return $this->roadNumber;
    }

    public function setRoadNumber(?int $roadNumber): self
    {
        $this->roadNumber = $roadNumber;

        return $this;
    }

    public function getRoadName(): ?string
    {
        return $this->roadName;
    }

    public function setRoadName(string $roadName): self
    {
        $this->roadName = $roadName;

        return $this;
    }

    public function getRoadName2(): ?string
    {
        return $this->roadName2;
    }

    public function setRoadName2(?string $roadName2): self
    {
        $this->roadName2 = $roadName2;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

    /**
     * @return Collection|Artwork[]
     */
    public function getArtworks(): Collection
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): self
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks[] = $artwork;
            $artwork->addEvent($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            $artwork->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->artists->removeElement($artist);

        return $this;
    }
}
