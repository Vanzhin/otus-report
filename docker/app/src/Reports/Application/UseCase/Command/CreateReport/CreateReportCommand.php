<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\CreateReport;

use App\Shared\Application\Command\Command;

readonly class CreateReportCommand extends Command
{
    public function __construct(
        public string $title,
        public string $template,
        public string $creatorId,
        public string $approverId,
        public array  $variables = [],
    )
    {
    }
}
