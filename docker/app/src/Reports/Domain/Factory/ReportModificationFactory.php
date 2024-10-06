<?php
declare(strict_types=1);


namespace App\Reports\Domain\Factory;

use App\Reports\Domain\Aggregate\Report\Report;
use App\Reports\Domain\Aggregate\Report\ReportModification;
use App\Reports\Domain\Aggregate\Report\Specification\ReportModificationSpecification;

readonly class ReportModificationFactory
{
    public function __construct(private ReportModificationSpecification $specification)
    {
    }

    public function create(
        Report $report,
        string $status,
    ): ReportModification
    {
        return new ReportModification(
            $report,
            $status,
            $this->specification,
        );
    }

}