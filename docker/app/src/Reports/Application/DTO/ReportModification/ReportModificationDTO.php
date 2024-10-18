<?php

declare(strict_types=1);

namespace App\Reports\Application\DTO\ReportModification;

class ReportModificationDTO
{
    public string $status;
    public string $changed_at;
    public ?string $comment = null;
}
