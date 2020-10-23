<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EndpointRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Endpoint implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": true})
     * @var bool
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $server;

    /**
     * @ORM\Column(name="streamKey", type="string", length=255)
     * @var string
     */
    private $streamKey;

    /**
     * @ORM\Column(name="channelName", type="string", length=255)
     * @var string
     */
    private $channelName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Streams", inversedBy="endpoints")
     * @ORM\JoinColumn(name="stream_id", referencedColumnName="id")
     */
    private $stream;

    /**
     * @return int
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Endpoint
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Endpoint
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getServer(): ?string
    {
        return $this->server;
    }

    /**
     * @param string $server
     * @return Endpoint
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setServer(string $server): self
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return null|string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getStreamKey(): ?string
    {
        return $this->streamKey;
    }

    /**
     * @param string $streamKey
     * @return Endpoint
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setStreamKey(string $streamKey): self
    {
        $this->streamKey = $streamKey;

        return $this;
    }

    /**
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getStream(): ?Streams
    {
        return $this->stream;
    }

    /**
     * @param mixed $stream
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setStream($stream): void
    {
        $this->stream = $stream;
    }

    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getChannelName(): string
    {
        return $this->channelName;
    }

    /**
     * @param string $channelName
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setChannelName(string $channelName): void
    {
        $this->channelName = $channelName;
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
     * @return array|mixed
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
