<?php

namespace Metropolitan\Test\Model;

class CrmLeadModelMpd extends CrmLeadModelBase
{
    private ?string $mpdId = null;

    private ?string $orderFile = null;

    private ?string $message = null;

    private ?string $profileLink = null;

    public function getMpdId(): ?string
    {
        return $this->mpdId;
    }

    public function setMpdId(?string $mpdId): self
    {
        $this->mpdId = $mpdId;
        return $this;
    }

    public function getOrderFile(): ?string
    {
        return $this->orderFile;
    }

    public function setOrderFile(?string $orderFile): self
    {
        $this->orderFile = $orderFile;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getProfileLink(): ?string
    {
        return $this->profileLink;
    }

    public function setProfileLink(?string $profileLink): self
    {
        $this->profileLink = $profileLink;
        return $this;
    }

}