<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Query\FindReport;

use App\Shared\Application\Query\Query;

readonly class FindReportQuery extends Query
{
    public function __construct(public string $reportId, public string $userId)
    {
    }
}
