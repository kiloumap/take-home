<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Restaurant
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "string", length: 100)]
    private string $addressLine1;

    #[ORM\Column(type: "string", length: 100, nullable: true, options: ["nullable", "default" => null])]
    private ?string $addressLine2;

    #[ORM\Column(type: "string", length: 100, nullable: true, options: ["default" => null])]
    private ?string $addressLine3;

    #[ORM\Column(type: "string", length: 10)]
    private string $postalCode;

    #[ORM\Column(type: "string", length: 100)]
    private string $city;

    #[ORM\Column(type: "string", length: 100, nullable: true, options: ["default" => null])]
    private ?string $state;

    #[ORM\Column(type: "string", length: 100)]
    private string $country;

    #[ORM\Column(type: "string", length: 20)]
    private string $phone;

    #[ORM\Column(type: "string", length: 100)]
    private string $email;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private bool $pickup;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private bool $delivery;

    #[ORM\ManyToOne(targetEntity: "App\Restaurant\Domain\Model\Owner", inversedBy: "restaurants", cascade: ['persist'])]
    #[ORM\JoinColumn(name: "owner_id", referencedColumnName: "id")]
    private Owner $owner;

    public function setId(?Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setAddressLine1(string $addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function setAddressLine2(?string $addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function setAddressLine3(?string $addressLine3): self
    {
        $this->addressLine3 = $addressLine3;

        return $this;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPickup(bool $pickup): self
    {
        $this->pickup = $pickup;

        return $this;
    }

    public function setDelivery(bool $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
