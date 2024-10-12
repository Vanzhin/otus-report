<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

enum ReportStatus: string
{
    case CREATED = 'created';

    case SEND_TO_APPROVE = 'send_to_approve';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getBlockedStatuses(): array
    {
        return array_column([self::APPROVED, self::SEND_TO_APPROVE], 'value');
    }

}