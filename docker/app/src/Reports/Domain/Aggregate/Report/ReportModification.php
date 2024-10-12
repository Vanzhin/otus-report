<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

use App\Reports\Domain\Aggregate\Report\Specification\ReportModificationSpecification;
use App\Reports\Domain\Event\ReportModificationCreatedEvent;
use App\Shared\Domain\Aggregate\Aggregate;
use App\Shared\Domain\Service\UlidService;

class ReportModification extends Aggregate
{
    private string $id;
    private \DateTimeImmutable $changedAt;
    private ReportStatus $status;
    private ReportModificationSpecification $specification;

    public function __construct(
        private Report                  $report,
        string                          $status,
        ReportModificationSpecification $specification,
    )
    {
        $this->id = UlidService::generate();
        $this->changedAt = new \DateTimeImmutable();
        $this->specification = $specification;
        $this->setStatus($status);
        $this->raise(new ReportModificationCreatedEvent($report->getId(), $this->status->value));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getChangedAt(): \DateTimeImmutable
    {
        return $this->changedAt;
    }

    public function getStatus(): ReportStatus
    {
        return $this->status;
    }

    public function getReport(): Report
    {
        return $this->report;
    }

    private function setStatus(string $status): void
    {
        $this->status = ReportStatus::from($status);
        $this->specification->allowAddModificationToReportSpecification->satisfy($this);
    }

}