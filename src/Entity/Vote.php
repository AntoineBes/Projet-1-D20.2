<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user_vote")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\conference", inversedBy="conf_vote")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conf_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getConfId(): ?conference
    {
        return $this->conf_id;
    }

    public function setConfId(?conference $conf_id): self
    {
        $this->conf_id = $conf_id;

        return $this;
    }
}
