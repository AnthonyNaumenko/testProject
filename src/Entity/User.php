<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var Advert[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="user")
     */
    private $advert;

    public function __construct()
    {
        parent::__construct();
        $this->username = '';
        $this->password = '';
        $this->email = '';
        $this->roles = ['ROLE_USER'];
        $this->advert = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection/Advert[]
     */
    public function getAdvert(): Collection
    {
        return $this->advert;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->advert->contains($advert)) {
            $this->advert[] = $advert;
            $advert->setUser($this);
        }
        return $this;
    }


}
