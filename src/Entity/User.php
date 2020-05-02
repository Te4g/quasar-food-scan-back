<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read", "user"}},
 *     denormalizationContext={"groups"={"user:write", "user"}}
 * )
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
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("user")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     * @Groups("user:write")
     * @Assert\NotCompromisedPassword()
     */
    private $password;

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
     * @ORM\Column(type="date", nullable=true)
     * @Groups("user")
     * @Assert\Date()
     */
    private $birthDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("user")
     * @Assert\Positive()
     * @Assert\LessThan("200")
     */
    private $weight;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("user")
     * @Assert\Positive()
     * @Assert\LessThan("250")
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("user")
     */
    private $gender;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("user")
     */
    private $activityLevel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user")
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $weightHistory = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DailyFood", mappedBy="user", orphanRemoval=true)
     */
    private $dailyFoods;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pantry", mappedBy="user", cascade={"persist", "remove"})
     */
    private $pantry;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProductHistory", mappedBy="user", orphanRemoval=true)
     */
    private $userProductHistories;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    public function __construct()
    {
        $this->dailyFoods = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->userProductHistories = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getActivityLevel(): ?int
    {
        return $this->activityLevel;
    }

    public function setActivityLevel(int $activityLevel): self
    {
        $this->activityLevel = $activityLevel;

        return $this;
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

    public function getWeightHistory(): ?array
    {
        return $this->weightHistory;
    }

    public function setWeightHistory(?array $weightHistory): self
    {
        $this->weightHistory = $weightHistory;

        return $this;
    }

    /**
     * @return Collection|DailyFood[]
     */
    public function getDailyFoods(): Collection
    {
        return $this->dailyFoods;
    }

    public function addDailyFood(DailyFood $dailyFood): self
    {
        if (!$this->dailyFoods->contains($dailyFood)) {
            $this->dailyFoods[] = $dailyFood;
            $dailyFood->setUser($this);
        }

        return $this;
    }

    public function removeDailyFood(DailyFood $dailyFood): self
    {
        if ($this->dailyFoods->contains($dailyFood)) {
            $this->dailyFoods->removeElement($dailyFood);
            // set the owning side to null (unless already changed)
            if ($dailyFood->getUser() === $this) {
                $dailyFood->setUser(null);
            }
        }

        return $this;
    }

    public function getPantry(): ?Pantry
    {
        return $this->pantry;
    }

    public function setPantry(Pantry $pantry): self
    {
        $this->pantry = $pantry;

        // set the owning side of the relation if necessary
        if ($pantry->getUser() !== $this) {
            $pantry->setUser($this);
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
            $userProductHistory->setUser($this);
        }

        return $this;
    }

    public function removeUserProductHistory(UserProductHistory $userProductHistory): self
    {
        if ($this->userProductHistories->contains($userProductHistory)) {
            $this->userProductHistories->removeElement($userProductHistory);
            // set the owning side to null (unless already changed)
            if ($userProductHistory->getUser() === $this) {
                $userProductHistory->setUser(null);
            }
        }

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
