<?php
declare(strict_types=1);


namespace App\Reports\Domain\Factory;

use App\Reports\Domain\Aggregate\Report\Report;
use App\Reports\Domain\Aggregate\Report\VO\ReportVariable;
use App\Reports\Domain\Aggregate\Report\VO\ReportVariables;

readonly class ReportFactory
{
    public function __construct(
        private ReportModificationFactory $reportModificationFactory,
    )
    {
    }

    public function create(
        string $title,
        string $template,
        string $creatorId,
        string $approverId,
        array  $variables = [],
    ): Report
    {
        $vars = new ReportVariables();
        foreach ($variables as $variable) {
            $vars->setVariable(new ReportVariable($variable['name'], $variable['value']));
        }

        return new Report(
            $title,
            $template,
            $vars->jsonSerialize(),
            $creatorId,
            $approverId,
            $this->reportModificationFactory
        );
    }
}