<?php

declare(strict_types=1);

namespace App\Reports\Application\Service\AccessController;

use App\Reports\Domain\Aggregate\Report\Report;

/**
 * Служба проверки прав доступа к профилям, пока так
 */
readonly class ReportAccessControl
{
    public function canAccess(string $userId, Report $report): bool
    {
        return ($report->isOwnedBy($userId) && $report->isApprovedBy($userId));
    }
}
