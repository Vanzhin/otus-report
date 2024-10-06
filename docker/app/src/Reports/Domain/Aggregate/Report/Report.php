<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

use App\Reports\Domain\Aggregate\Report\VO\ReportVariables;
use App\Reports\Domain\Event\ReportCreatedEvent;
use App\Reports\Domain\Factory\ReportModificationFactory;
use App\Shared\Domain\Aggregate\Aggregate;
use App\Shared\Domain\Service\UlidService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Report extends Aggregate
{
    private readonly string $id;
    private \DateTimeImmutable $createdAt;
    private ?string $path = null;

    /**
     * @var Collection<ReportModification>
     */
    private Collection $modifications;

    public function __construct(
        private string                             $title,
        private string                             $template,
        private array                              $variables,
        private readonly string                    $creatorId,
        private readonly string                    $approverId,
        private readonly ReportModificationFactory $reportModificationFactory,
    )
    {
        $this->id = UlidService::generate();
        $this->createdAt = new \DateTimeImmutable();
        $this->modifications = new ArrayCollection();
        $this->modifications->add($this->reportModificationFactory->create($this, ReportStatus::CREATED->value));
        $this->raise(new ReportCreatedEvent($creatorId, $this->id, ReportStatus::CREATED->value));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function getApproverId(): string
    {
        return $this->approverId;
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

    public function isOwnedBy(string $userId): bool
    {
        return $this->creatorId === $userId;
    }

    public function isApprovedBy(string $userId): bool
    {
        return $this->approverId === $userId;
    }

    public function getModifications(): Collection
    {
        return $this->modifications;
    }

    public function getVariables(): ReportVariables|array
    {
        return $this->variables;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }

    public function getLastModification(): ?ReportModification
    {
        return $this->modifications->last();
    }

}