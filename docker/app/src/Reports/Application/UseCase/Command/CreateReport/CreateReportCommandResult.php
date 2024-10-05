<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\CreateReport;

class CreateReportCommandResult
{
    public function __construct(
        public string $id,
    )
    {
    }
}
