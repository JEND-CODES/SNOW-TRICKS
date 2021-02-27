<?php

namespace App\Entity;

// Pas besoin d'appeller ça ?
// use App\Repository\MentionRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// -> Ajouté pour régler les conditions de validation du formulaire éditeur d'article
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MentionRepository")
 */
class Mention
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message="Commentaire manquant"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="mentions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="mentions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    // Cette fonction enregistre l'ID de chaque Figure (article) associée aux Mentions (commentaires). Elle est appelée dans la fonction "show" de BlogController :
    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

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
