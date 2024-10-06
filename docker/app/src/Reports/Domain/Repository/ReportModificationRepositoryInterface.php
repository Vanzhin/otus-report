<?php
declare(strict_types=1);


namespace App\Reports\Domain\Repository;

use App\Reports\Domain\Aggregate\Report\ReportModification;

interface ReportModificationRepositoryInterface
{
    public function save(ReportModification $modification): void;

    public function findPreviousByReportId(string $reportId): ?ReportModification;

}