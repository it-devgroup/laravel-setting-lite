<?php

namespace ItDevgroup\LaravelSettingLite\Model;

/**
 * Class SettingFilter
 * @package ItDevgroup\LaravelSettingLite\Model
 */
class SettingFilter
{
    /**
     * @var string|null
     */
    private ?string $key = null;
    /**
     * @var string|null
     */
    private ?string $type = null;
    /**
     * @var string|null
     */
    private ?string $group = null;
    /**
     * @var bool|null
     */
    private ?bool $isPublic = null;

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return self
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return self
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param string|null $group
     * @return self
     */
    public function setGroup(?string $group): self
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPublic(): ?bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool|null $isPublic
     * @return self
     */
    public function setIsPublic(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;
        return $this;
    }
}
