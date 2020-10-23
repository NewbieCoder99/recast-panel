<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class Queue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $task;

    /**
     * @return int
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * @param string $task
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function setTask(string $task): void
    {
        $this->task = $task;
    }
}
