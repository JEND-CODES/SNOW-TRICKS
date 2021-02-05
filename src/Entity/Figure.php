<?php

namespace App\Entity;

// Pas besoin d'appeller ça ?
// use App\Repository\FigureRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// -> Ajouté pour régler les conditions de validation du formulaire éditeur d'article
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FigureRepository")
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="Titre trop court")
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=10)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classification", inversedBy="figures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classification;

    // Ici, avec ORM ORDER BY on peut régler l'ordre de l'affichage des commentaires liés aux articles!!!! cf. https://symfony.com/doc/current/doctrine.html
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mention", mappedBy="figure", orphanRemoval=true)
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $mentions;


    // PRIVATE SCREENS CONFIGURATION :
    // Attention à bien déclarer cette dépendance de l'Entité Figure avec l'Entité Screen (car j'ai défini une relation entre le FigureType et le ScreenType)

    // 1er février -> j'ai ajouté la mention " cascade={"persist"} " car je me retrouvais avec le message d'erreur suivant : "A new entity was found through the relationship 'App\Entity\Figure#screens' that was not configured to cascade persist operations for entity. To solve this issue: Either explicitly call EntityManager#persist() on this unknown entity or configure cascade persist this association in the mapping for example @ManyToOne(..,cascade={"persist"}). If you cannot find out which entity causes the problem implement 'App\Entity\Screen#__toString()' to get a clue."

    // Mettre plutôt ? " cascade={"persist", "remove"} " ???

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Screen", mappedBy="figure", orphanRemoval=true, cascade={"persist"})
     */
    private $screens;
    
    // Mise à jour de l'entité pour autoriser un champs vide ou NULL : https://openclassrooms.com/forum/sujet/symfony-form-required-false
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image_one;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image_two;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image_three;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $video_one;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $video_two;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $video_three;
    
    
    
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

    // Attention à bien ajouter le ? avant le ?string pour autoriser la valeur NULL (il ne suffit pas d'indiquer nullable=true sur l'attribut de la classe, il faut aussi spécifier à ce niveau...)
    // En savoir plus : https://openclassrooms.com/forum/sujet/symfony-4-erreur-suite-a-ajout-de-nullable-true
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
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
            // set the owning side to null (unless already changed)
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
            // set the owning side to null (unless already changed)
            if ($screen->getFigure() === $this) {
                $screen->setFigure(null);
            }
        }

        return $this;
    }
    // Cf. https://symfony.com/doc/current/doctrine/reverse_engineering.html
    // Cf. https://symfony.com/doc/3.3/doctrine.html
    // Utiliser le terminal de commande pour mettre à jour une Entité : après avoir indiqué "private $graphtitle" avec son annotation, il suffit de faire un coup de  "php bin/console make:entity --regenerate App" et les getters/setters sont générés !
    // Pour mettre ensuite à jour la BDD faire un "php bin/console doctrine:schema:update --dump-sql" puis "php bin/console doctrine:schema:update --force"
    public function getImageOne(): ?string
    {
        return $this->image_one;
    }

    public function setImageOne(string $image_one): self
    {
        $this->image_one = $image_one;

        return $this;
    }

    public function getImageTwo(): ?string
    {
        return $this->image_two;
    }

    public function setImageTwo(?string $image_two): self
    {
        $this->image_two = $image_two;

        return $this;
    }

    public function getImageThree(): ?string
    {
        return $this->image_three;
    }

    public function setImageThree(?string $image_three): self
    {
        $this->image_three = $image_three;

        return $this;
    }

    public function getVideoOne(): ?string
    {
        return $this->video_one;
    }

    public function setVideoOne(string $video_one): self
    {
        $this->video_one = $video_one;

        return $this;
    }

    public function getVideoTwo(): ?string
    {
        return $this->video_two;
    }

    public function setVideoTwo(?string $video_two): self
    {
        $this->video_two = $video_two;

        return $this;
    }

    public function getVideoThree(): ?string
    {
        return $this->video_three;
    }

    public function setVideoThree(?string $video_three): self
    {
        $this->video_three = $video_three;

        return $this;
    }

   
}
