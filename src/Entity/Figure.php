<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FigureRepository")
 * @UniqueEntity(
 *      fields={"title"},
 *      message="Ce titre est déjà pris"
 * )
 */
class Figure
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\Length(
     *      min=4, 
     *      max=50, 
     *      minMessage="Titre trop court", 
     *      maxMessage = "Titre trop long"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(
     *      protocols = {"http", "https"},
     *      message = "URL non conforme"
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $freshDate;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $labelled;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classification", inversedBy="figures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classification;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mention", mappedBy="figure", orphanRemoval=true)
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $mentions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Screen", mappedBy="figure", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $screens;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
   
    public function __construct()
    {
        $this->mentions = new ArrayCollection();

        $this->screens = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClassification(): ?Classification
    {
        return $this->classification;
    }

    public function setClassification(?Classification $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * @return Collection|Mention[]
     */
    public function getMentions(): Collection
    {
        return $this->mentions;
    }

    public function addMention(Mention $mention): self
    {
        if (!$this->mentions->contains($mention)) {
            $this->mentions[] = $mention;
            $mention->setFigure($this);
        }

        return $this;
    }

    public function removeMention(Mention $mention): self
    {
        if ($this->mentions->contains($mention)) {
            $this->mentions->removeElement($mention);
            
            if ($mention->getFigure() === $this) {
                $mention->setFigure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Screen[]
     */
    public function getScreens(): Collection
    {
        return $this->screens;
    }

    public function addScreen(Screen $screen): self
    {
        if (!$this->screens->contains($screen)) {
            $this->screens[] = $screen;
            $screen->setFigure($this);
        }

        return $this;
    }

    public function removeScreen(Screen $screen): self
    {
        if ($this->screens->contains($screen)) {
            $this->screens->removeElement($screen);
            
            if ($screen->getFigure() === $this) {
                $screen->setFigure(null);
            }
        }

        return $this;
    }
  
    public function getFreshDate(): ?\DateTimeInterface
    {
        return $this->freshDate;
    }

    public function setFreshDate(?\DateTimeInterface $freshDate): self
    {
        $this->freshDate = $freshDate;

        return $this;
    }

    public function getLabelled(): ?string
    {
        return $this->labelled;
    }

    public function setLabelled(?string $labelled): self
    {
        $this->labelled = $labelled;

        return $this;
    }

    public function getUser(): ?Member
    {
        return $this->user;
    }

    public function setUser(?Member $user): self
    {
        $this->user = $user;

        return $this;
    }
    

   
}
