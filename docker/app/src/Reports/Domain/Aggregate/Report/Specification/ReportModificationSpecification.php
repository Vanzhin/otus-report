<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report\Specification;

use App\Shared\Domain\Specification\SpecificationInterface;

class ReportModificationSpecification implements SpecificationInterface
{
    public function __construct(public AllowAddModificationToReportSpecification $allowAddModificationToReportSpecification)
    {
    }

}