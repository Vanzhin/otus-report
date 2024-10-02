<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

use App\Shared\Domain\Service\UlidService;

class Report
{
    private readonly string $id;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;
    private ?string $path = null;
    private readonly ReportStatus $status;


    public function __construct(
        private string          $title,
        private string          $template,
        private ReportVariables $variables,
        private readonly string $creatorId,
        private readonly string $approverId,
    )
    {
        $this->id = UlidService::generate();
        $this->createdAt = new \DateTimeImmutable();
        $this->status = ReportStatus::CREATED;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function getApproverId(): string
    {
        return $this->approverId;
    }

    public function getStatus(): ReportStatus
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getVariables(): ReportVariables
    {
        return $this->variables;
    }

}