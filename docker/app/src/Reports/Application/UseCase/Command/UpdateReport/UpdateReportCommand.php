<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\UpdateReport;

use App\Reports\Application\DTO\Report\ReportDTO;
use App\Shared\Application\Command\Command;

readonly class UpdateReportCommand extends Command
{
    public function __construct(
        public string    $reportId,
        public ReportDTO $reportDTO,
        public string    $userId,
    )
    {
    }
}
