<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "user"})
     * @var string
     */
    private $role = 'user';

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Streams", mappedBy="user")
     * @var ArrayCollection
     */
    private $streams;

    /**
     * User constructor.
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct()
    {
        $this->streams = new ArrayCollection();
    }

    /**
     * @return int
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param DateTimeInterface $created_at
     * @return User
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return array
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getRoles()
    {
        return [strtoupper($this->role)];
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return array
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function eraseCredentials()
    {
        return [];
    }

    /**
     * @return ArrayCollection
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getStreams()
    {
        return $this->streams;
    }

    /**
     * @param mixed $streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setStreams($streams): void
    {
        $this->streams = $streams;
    }

    /**
     * @ORM\PrePersist()
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function prePersist()
    {
        $this->created_at = new DateTime();
    }

    /**
     * @return array|mixed
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
