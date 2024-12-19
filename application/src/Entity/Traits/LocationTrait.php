<?php
namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

trait LocationTrait {
    /**
     * @ORM\Column(type="boolean")
     * @Gedmo\Versioned
     * @Assert\Type("bool")
     */
    private $isPrimary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     */
    private $streetAddress1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $streetAddress2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=2, options={"fixed" = true}, nullable=true)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     * @Assert\Country
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     * @Assert\Length(max=10)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Url
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Length(max=50)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Length(max=50)
     */
    private $faxNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $latitudeAndLongitude;

    public function getIsPrimary(): bool {
        return $this->isPrimary;
    }

    public function setIsPrimary(bool $isPrimary): self {
        $this->isPrimary = $isPrimary;
        return $this;
    }

    public function getStreetAddress1(): ?string
    {
        return $this->streetAddress1;
    }

    public function setStreetAddress1(string $streetAddress1): self
    {
        $this->streetAddress1 = $streetAddress1;

        return $this;
    }

    public function getStreetAddress2(): ?string
    {
        return $this->streetAddress2;
    }

    public function setStreetAddress2(string $streetAddress2): self
    {
        $this->streetAddress2 = $streetAddress2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getFaxNumber(): ?string
    {
        return $this->faxNumber;
    }

    public function setFaxNumber(string $faxNumber): self
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    public function getLatitudeAndLongitude(): ?string
    {
        return $this->latitudeAndLongitude;
    }

    public function setLatitudeAndLongitude(string $latitudeAndLongitude): self
    {
        $this->latitudeAndLongitude = $latitudeAndLongitude;

        return $this;
    }

}