<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Query\FindReport;


use App\Reports\Application\DTO\Report\ReportDTO;

readonly class FindReportQueryResult
{
    public function __construct(public ?ReportDTO $report)
    {
    }
}
