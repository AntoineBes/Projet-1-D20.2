<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
/**
 * @ORM\Id()     
 * @ORM\GeneratedValue()
 * @ORM\Column(type="integer")
 */
private $id;

/**
 * @Assert\NotBlank()
 * @Assert\Email()     
 * @ORM\Column(type="string", length=255, unique=true)
 */
private $email;

/**
 * @ORM\Column(type="string", length=255, nullable=true)
 */
private $lastname;

/**
 * @ORM\Column(type="string", length=255, nullable=true)
 */
private $firstname;



/**
 * @ORM\Column(type="simple_array")
 */
private $roles;
/**
 * @ORM\Column()
 */
private $password;

/**
 * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="user_id")
 */
private $user_vote;


public function __construct()
{
$this->roles = array('ROLE_USER');
$this->user_vote = new ArrayCollection();
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

public function getLastname(): ?string
{
return $this->lastname;
}

public function setLastname(?string $lastname): self
{
$this->lastname = $lastname;
return $this;
}

public function getFirstname(): ?string
{
return $this->firstname;
}

public function setFirstname(?string $firstname): self
{
$this->firstname = $firstname;
return $this;
}

public function getPassword()
{
return $this->password;
}

public function setPassword($password)
{
$this->password = $password;
}

public function getRoles()
{
return $this->roles;
}

public function setRoles($roles)
{
$this->roles = $roles;
return $this;
}

public function getSalt()
{
return null;
}
public function getUsername()
{
return $this->email;
}
public function eraseCredentials(){

}

/**
 * @return Collection|Vote[]
 */
public function getUserVote(): Collection
{
    return $this->user_vote;
}

public function addUserVote(Vote $userVote): self
{
    if (!$this->user_vote->contains($userVote)) {
        $this->user_vote[] = $userVote;
        $userVote->setUserId($this);
    }

    return $this;
}

public function removeUserVote(Vote $userVote): self
{
    if ($this->user_vote->contains($userVote)) {
        $this->user_vote->removeElement($userVote);
        // set the owning side to null (unless already changed)
        if ($userVote->getUserId() === $this) {
            $userVote->setUserId(null);
        }
    }

    return $this;
}





}
