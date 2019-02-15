<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConferenceRepository")
 */
class Conference
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intervenant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sousTitre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="conf_id")
     */
    private $conf_vote;

    public function __construct()
    {
        $this->conf_vote = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getIntervenant(): ?string
    {
        return $this->intervenant;
    }

    public function setIntervenant(?string $intervenant): self
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getSousTitre(): ?string
    {
        return $this->sousTitre;
    }

    public function setSousTitre(?string $sousTitre): self
    {
        $this->sousTitre = $sousTitre;

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getConfVote(): Collection
    {
        return $this->conf_vote;
    }

    public function addConfVote(Vote $confVote): self
    {
        if (!$this->conf_vote->contains($confVote)) {
            $this->conf_vote[] = $confVote;
            $confVote->setConfId($this);
        }

        return $this;
    }

    public function removeConfVote(Vote $confVote): self
    {
        if ($this->conf_vote->contains($confVote)) {
            $this->conf_vote->removeElement($confVote);
            // set the owning side to null (unless already changed)
            if ($confVote->getConfId() === $this) {
                $confVote->setConfId(null);
            }
        }

        return $this;
    }


}
