<?php
declare(strict_types=1);


namespace App\Reports\Domain\Event;

use App\Shared\Domain\Event\EventInterface;

class ReportCreatedEvent implements EventInterface
{
    public function __construct(public string $userId, public string $reportId, public string $status)
    {
    }

}