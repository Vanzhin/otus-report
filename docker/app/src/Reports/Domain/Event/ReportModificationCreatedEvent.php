<?php
declare(strict_types=1);


namespace App\Reports\Domain\Event;

use App\Reports\Domain\Aggregate\Report\Report;
use App\Shared\Domain\Event\EventInterface;

class ReportModificationCreatedEvent implements EventInterface
{
    public function __construct(public Report $report, public string $status)
    {
    }
}