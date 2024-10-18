<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\AddModificationToReport;

use App\Shared\Application\Command\Command;

readonly class AddModificationToReportCommand extends Command
{
    public function __construct(
        public string  $userId,
        public string  $reportId,
        public string  $newStatus,
        public ?string $comment = null
    )
    {
    }
}
