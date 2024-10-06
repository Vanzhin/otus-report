<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\UpdateReport;

class UpdateReportCommandResult
{
    public function __construct(
        public string $id,
    )
    {
    }
}
