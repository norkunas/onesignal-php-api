<?php

declare(strict_types=1);

namespace OneSignal\Response\Segment;

use DateTimeImmutable;
use OneSignal\Dto\AbstractDto;

class Segment implements AbstractDto
{
    /**
     * @var non-empty-string
     */
    protected string $id;

    /**
     * @var non-empty-string
     */
    protected string $name;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    /**
     * @var non-empty-string
     */
    protected string $appId;

    protected bool $readOnly;

    protected bool $isActive;

    /**
     * @param non-empty-string $id
     * @param non-empty-string $name
     * @param non-empty-string $createdAt
     * @param non-empty-string $updatedAt
     * @param non-empty-string $appId
     */
    public function __construct(
        string $id,
        string $name,
        string $createdAt,
        string $updatedAt,
        string $appId,
        bool $readOnly,
        bool $isActive
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = new DateTimeImmutable($createdAt);
        $this->updatedAt = new DateTimeImmutable($updatedAt);
        $this->appId = $appId;
        $this->readOnly = $readOnly;
        $this->isActive = $isActive;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'app_id' => $this->getAppId(),
            'read_only' => $this->getReadOnly(),
            'is_active' => $this->getIsActive(),
        ];
    }
}
