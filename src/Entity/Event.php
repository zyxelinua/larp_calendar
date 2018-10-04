<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceMax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $priceCurrency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $organizers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $organizerContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactSite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactFB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactOther;

    /**
     * @ORM\ManyToOne(targetEntity="EventType", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="EventCategory", inversedBy="events")
     * @ORM\JoinTable(name="event_event_category")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPriceMin(): ?int
    {
        return $this->priceMin;
    }

    public function setPriceMin(?int $priceMin): self
    {
        $this->priceMin = $priceMin;

        return $this;
    }

    public function getPriceMax(): ?int
    {
        return $this->priceMax;
    }

    public function setPriceMax(?int $priceMax): self
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function setPriceCurrency(?string $priceCurrency): self
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    public function getOrganizers(): ?string
    {
        return $this->organizers;
    }

    public function setOrganizers(string $organizers): self
    {
        $this->organizers = $organizers;

        return $this;
    }

    public function getOrganizerContact(): ?string
    {
        return $this->organizerContact;
    }

    public function setOrganizerContact(string $organizerContact): self
    {
        $this->organizerContact = $organizerContact;

        return $this;
    }

    public function getContactSite(): ?string
    {
        return $this->contactSite;
    }

    public function setContactSite(?string $contactSite): self
    {
        $this->contactSite = $contactSite;

        return $this;
    }

    public function getContactFB(): ?string
    {
        return $this->contactFB;
    }

    public function setContactFB(?string $contactFB): self
    {
        $this->contactFB = $contactFB;

        return $this;
    }

    public function getContactOther(): ?string
    {
        return $this->contactOther;
    }

    public function setContactOther(?string $contactOther): self
    {
        $this->contactOther = $contactOther;

        return $this;
    }

    public function getType(): ?EventType
    {
        return $this->type;
    }

    public function setType(?EventType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return EventCategory[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories): self
    {
        $this->categories = $categories;

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

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
