<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $task_description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status_task = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskDescription(): ?string
    {
        return $this->task_description;
    }

    public function setTaskDescription(string $task_description): self
    {
        $this->task_description = $task_description;

        return $this;
    }

    public function isStatusTask(): ?bool
    {
        return $this->status_task;
    }

    public function setStatusTask(?bool $status_task): self
    {
        $this->status_task = $status_task;

        return $this;
    }
}
