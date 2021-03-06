<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 * @UniqueEntity(
 *  fields= {"email"},
 *  message= "Cet email est déjà utilisé"
 * )
 * @UniqueEntity(
 *  fields={"username"},
 *  message="Ce pseudo est déjà pris"
 * )
 */
class Member implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\Length(
     *      max=50, 
     *      maxMessage="Pseudo trop long. Maximum 50 caractères"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Length(
     *      min=8,
     *      max=80,
     *      minMessage="Votre mot de passe doit comporter au moins 8 caractères",
     *      maxMessage="Votre mot de passe ne doit pas excéder 80 caractères"
     * )
     */
    private $password;
    
    /**
     * @Assert\EqualTo(propertyPath="password", message="Erreur de confirmation du mot de passe")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mention", mappedBy="user", orphanRemoval=true)
     */
    private $mentions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Figure", mappedBy="user", orphanRemoval=true)
     */
    private $tricks;

    public function __construct()
    {
        $this->mentions = new ArrayCollection();
        $this->tricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

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
            $mention->setMember($this);
        }

        return $this;
    }

    public function removeMention(Mention $mention): self
    {
        if ($this->mentions->removeElement($mention)) {
            
            if ($mention->getMember() === $this) {
                $mention->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Figure[]
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Figure $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }

        return $this;
    }

    public function removeTrick(Figure $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function eraseCredentials() {}
    
    public function getSalt() {}
    
    public function getRoles() 
    {
        return [$this->getRole()];
    }

    
}
