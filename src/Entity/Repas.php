<?php

namespace App\Entity;

use App\Repository\RepasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepasRepository::class)
 */
class Repas
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
    private $produit;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=The::class, mappedBy="repas")
     */
    private $the;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="repas")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="repas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Picnic::class, mappedBy="repas")
     */
    private $picnics;



    /**
     * @ORM\OneToMany(targetEntity=Jus::class, mappedBy="repas")
     */
    private $juses;

    /**
     * @ORM\OneToMany(targetEntity=Eau::class, mappedBy="repas")
     */
    private $eaus;

    /**
     * @ORM\OneToMany(targetEntity=Vin::class, mappedBy="repas")
     */
    private $vins;

    /**
     * @ORM\OneToMany(targetEntity=Limonade::class, mappedBy="repas")
     */
    private $limonades;

    public function __construct()
    {
        $this->the = new ArrayCollection();
        $this->boisson = new ArrayCollection();
        $this->menu = new ArrayCollection();
        $this->picnics = new ArrayCollection();
        $this->juses = new ArrayCollection();
        $this->eaus = new ArrayCollection();
        $this->vins = new ArrayCollection();
        $this->limonades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|The[]
     */
    public function getThe(): Collection
    {
        return $this->the;
    }

    public function addThe(The $the): self
    {
        if (!$this->the->contains($the)) {
            $this->the[] = $the;
            $the->setRepas($this);
        }

        return $this;
    }

    public function removeThe(The $the): self
    {
        if ($this->the->contains($the)) {
            $this->the->removeElement($the);
            // set the owning side to null (unless already changed)
            if ($the->getRepas() === $this) {
                $the->setRepas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
            $menu->setRepas($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menu->contains($menu)) {
            $this->menu->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getRepas() === $this) {
                $menu->setRepas(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Picnic[]
     */
    public function getPicnics(): Collection
    {
        return $this->picnics;
    }

    public function addPicnic(Picnic $picnic): self
    {
        if (!$this->picnics->contains($picnic)) {
            $this->picnics[] = $picnic;
            $picnic->setRepas($this);
        }

        return $this;
    }

    public function removePicnic(Picnic $picnic): self
    {
        if ($this->picnics->contains($picnic)) {
            $this->picnics->removeElement($picnic);
            // set the owning side to null (unless already changed)
            if ($picnic->getRepas() === $this) {
                $picnic->setRepas(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Jus[]
     */
    public function getJuses(): Collection
    {
        return $this->juses;
    }

    public function addJus(Jus $jus): self
    {
        if (!$this->juses->contains($jus)) {
            $this->juses[] = $jus;
            $jus->setRepas($this);
        }

        return $this;
    }

    public function removeJus(Jus $jus): self
    {
        if ($this->juses->contains($jus)) {
            $this->juses->removeElement($jus);
            // set the owning side to null (unless already changed)
            if ($jus->getRepas() === $this) {
                $jus->setRepas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Eau[]
     */
    public function getEaus(): Collection
    {
        return $this->eaus;
    }

    public function addEau(Eau $eau): self
    {
        if (!$this->eaus->contains($eau)) {
            $this->eaus[] = $eau;
            $eau->setRepas($this);
        }

        return $this;
    }

    public function removeEau(Eau $eau): self
    {
        if ($this->eaus->contains($eau)) {
            $this->eaus->removeElement($eau);
            // set the owning side to null (unless already changed)
            if ($eau->getRepas() === $this) {
                $eau->setRepas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vin[]
     */
    public function getVins(): Collection
    {
        return $this->vins;
    }

    public function addVin(Vin $vin): self
    {
        if (!$this->vins->contains($vin)) {
            $this->vins[] = $vin;
            $vin->setRepas($this);
        }

        return $this;
    }

    public function removeVin(Vin $vin): self
    {
        if ($this->vins->contains($vin)) {
            $this->vins->removeElement($vin);
            // set the owning side to null (unless already changed)
            if ($vin->getRepas() === $this) {
                $vin->setRepas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Limonade[]
     */
    public function getLimonades(): Collection
    {
        return $this->limonades;
    }

    public function addLimonade(Limonade $limonade): self
    {
        if (!$this->limonades->contains($limonade)) {
            $this->limonades[] = $limonade;
            $limonade->setRepas($this);
        }

        return $this;
    }

    public function removeLimonade(Limonade $limonade): self
    {
        if ($this->limonades->contains($limonade)) {
            $this->limonades->removeElement($limonade);
            // set the owning side to null (unless already changed)
            if ($limonade->getRepas() === $this) {
                $limonade->setRepas(null);
            }
        }

        return $this;
    }
}
