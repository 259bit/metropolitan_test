<?php

namespace Metropolitan\Test\Model;

class CrmLeadModelBase
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $lastName = null;

    private ?string $mobilePhone = null;

    private ?string $email = null;

    private ?int $assignedId = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $param): self
    {
        $this->id = $param;
        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(?string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getAssignedId(): ?int
    {
        return $this->assignedId;
    }

    public function setAssignedId(string $param): self
    {
        $this->assignedId = $param;
        return $this;
    }


}