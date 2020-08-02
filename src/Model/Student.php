<?php

namespace App\Model;

class Student
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $age;

    /**
     * @var Group
     */
    private $group;

    /**
     * @var int
     */
    private $groupId;

    public function __construct(int $id, string $name, int $age, int $groupId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->groupId = $groupId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getGroupName(): ?string
    {
        return $this->group !== null
            ? $this->group->getName()
            : null;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }
}
