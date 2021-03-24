<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\OneToMany(targetEntity=Statistic::class, mappedBy="client")
     */
    private $statistics;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $number_beer;

    public function __construct()
    {
        $this->statistics = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Statistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(Statistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setClient($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getClient() === $this) {
                $statistic->setClient(null);
            }
        }

        return $this;
    }

    public function getNumberBeer(): ?int
    {
        return $this->number_beer;
    }

    public function setNumberBeer(int $number_beer): self
    {
        $this->number_beer = $number_beer;

        return $this;
    }
}
