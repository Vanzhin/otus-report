<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report\Specification;

use App\Reports\Domain\Aggregate\Report\ReportModification;
use App\Reports\Domain\Aggregate\Report\ReportStatus;
use App\Reports\Domain\Repository\ReportModificationRepositoryInterface;
use App\Shared\Domain\Service\AssertService;
use App\Shared\Domain\Specification\SpecificationInterface;

class AllowAddModificationToReportSpecification implements SpecificationInterface
{
    private const array ALLOWED_STATUSES_TO_CHANGE = [
        ReportStatus::CREATED->value => [
            ReportStatus::SEND_TO_APPROVE->value
        ],
        ReportStatus::SEND_TO_APPROVE->value => [
            ReportStatus::APPROVED->value,
            ReportStatus::REJECTED->value,
        ],
        ReportStatus::REJECTED->value => [
            ReportStatus::SEND_TO_APPROVE->value
        ],
        ReportStatus::APPROVED->value => [
        ],

    ];

    public function __construct(private ReportModificationRepositoryInterface $repository)
    {
    }

    public function satisfy(ReportModification $modification): void
    {
        $previousModification = $this->repository->findPreviousByReportId($modification->getReport()->getId());
        $previousStatus = $previousModification?->getStatus()->value;
        $newStatus = $modification->getStatus()->value;
        AssertService::false($previousStatus === $newStatus, sprintf('Report status is \'%s\' already.', $newStatus));
        if ($previousStatus) {
            AssertService::inArray($newStatus, self::ALLOWED_STATUSES_TO_CHANGE[$previousStatus]);
        }
    }
}