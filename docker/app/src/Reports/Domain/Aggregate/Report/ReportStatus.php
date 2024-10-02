<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service_locator;

enum ReportStatus: string
{
    case CREATED = 'created';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

}