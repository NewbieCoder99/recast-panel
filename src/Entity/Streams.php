<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;


/**
 * @ORM\Entity(repositoryClass="App\Repository\StreamsRepository")
 * @ORM\Table(name="streams",
 *     uniqueConstraints={
 *          @UniqueConstraint(name="stream_name",
 *              columns={"name", "user_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Streams implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    private $active;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": false})
     */
    private $live = false;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @var int
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="streams")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Endpoint", mappedBy="stream", orphanRemoval=true)
     */
    private $endpoints;

    /**
     * @ORM\Column(name="stream_key", type="string", length=255, nullable=false)
     * @var string
     */
    private $streamKey;

    /**
     * Streams constructor.
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct()
    {
        $this->endpoints = new ArrayCollection();
    }

    /**
     * @return int
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool|null
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return int|null
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param User $user
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param ArrayCollection $endpoints
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setEndpoints($endpoints): ArrayCollection
    {
        $this->endpoints = $endpoints;
        return $this;
    }

    /**
     * @return User
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getStreamKey(): string
    {
        return $this->streamKey;
    }

    /**
     * @param string $streamKey
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setStreamKey(string $streamKey): Streams
    {
        $this->streamKey = $streamKey;
        return $this;
    }

    /**
     * @return mixed
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getLive()
    {
        return $this->live;
    }

    /**
     * @param mixed $live
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setLive($live): void
    {
        $this->live = $live;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * @author Soner Sayakci <shyim@posteo.de>
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateConfig(LifecycleEventArgs $args): void
    {
        $args->getEntityManager()->getConnection()->insert('queue', ['task' => 'generate_config']);
    }

    /**
     * @ORM\PrePersist()
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function prePersist(): void
    {
        $this->streamKey = uniqid('', true);
    }

    /**
     * @ORM\PreUpdate()
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function preUpdate(): void
    {
        if (empty($this->streamKey)) {
            $this->prePersist();
        }
    }
}
