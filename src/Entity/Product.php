<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\EntityListeners({"App\EventListener\ProductListener"})
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
    private $code;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $dateHistory = [];

    /**
     * @ORM\Column(type="float")
     */
    private $totalQuantityConsummed = 0;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $details = [];

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pantry", mappedBy="product")
     */
    private $pantries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProductHistory", mappedBy="product", orphanRemoval=true)
     */
    private $userProductHistories;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInStock = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityInStock = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->pantries = new ArrayCollection();
        $this->userProductHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDateHistory(): ?array
    {
        return $this->dateHistory;
    }

    public function setDateHistory(?array $dateHistory): self
    {
        $this->dateHistory = $dateHistory;

        return $this;
    }

    public function getTotalQuantityConsummed(): ?float
    {
        return $this->totalQuantityConsummed;
    }

    public function setTotalQuantityConsummed(?float $totalQuantityConsummed): self
    {
        $this->totalQuantityConsummed = $totalQuantityConsummed;

        return $this;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails(?array $details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Collection|Pantry[]
     */
    public function getPantries(): Collection
    {
        return $this->pantries;
    }

    public function addPantry(Pantry $pantry): self
    {
        if (!$this->pantries->contains($pantry)) {
            $this->pantries[] = $pantry;
            $pantry->addProduct($this);
        }

        return $this;
    }

    public function removePantry(Pantry $pantry): self
    {
        if ($this->pantries->contains($pantry)) {
            $this->pantries->removeElement($pantry);
            $pantry->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|UserProductHistory[]
     */
    public function getUserProductHistories(): Collection
    {
        return $this->userProductHistories;
    }

    public function addUserProductHistory(UserProductHistory $userProductHistory): self
    {
        if (!$this->userProductHistories->contains($userProductHistory)) {
            $this->userProductHistories[] = $userProductHistory;
            $userProductHistory->setProduct($this);
        }

        return $this;
    }

    public function removeUserProductHistory(UserProductHistory $userProductHistory): self
    {
        if ($this->userProductHistories->contains($userProductHistory)) {
            $this->userProductHistories->removeElement($userProductHistory);
            // set the owning side to null (unless already changed)
            if ($userProductHistory->getProduct() === $this) {
                $userProductHistory->setProduct(null);
            }
        }

        return $this;
    }

    public function getIsInStock(): ?bool
    {
        return $this->isInStock;
    }

    public function setIsInStock(bool $isInStock): self
    {
        $this->isInStock = $isInStock;

        return $this;
    }

    public function getQuantityInStock(): ?int
    {
        return $this->quantityInStock;
    }

    public function setQuantityInStock(int $quantityInStock): self
    {
        $this->quantityInStock = $quantityInStock;

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
}
