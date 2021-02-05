<?php

namespace App\Entity;

// Pas besoin d'appeller ça ?
use App\Repository\ScreenRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ScreenRepository::class)
 */
class Screen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // On peut ici mettre un ASSERT qui vérifie le type de champ (image, vidéo..)
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $thumbnail;


    // Mettre plutôt ? " @ORM\JoinColumn(onDelete="CASCADE") " ???
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="screens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    // Attention à bien ajouter le ? avant le ?string pour autoriser la valeur NULL (il ne suffit pas d'indiquer nullable=true sur l'attribut de la classe, il faut aussi spécifier à ce niveau...)
    // En savoir plus : https://openclassrooms.com/forum/sujet/symfony-4-erreur-suite-a-ajout-de-nullable-true
    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    // Cette fonction enregistre l'ID de chaque Figure (article) associée aux Screens (commentaires)
    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }





}
