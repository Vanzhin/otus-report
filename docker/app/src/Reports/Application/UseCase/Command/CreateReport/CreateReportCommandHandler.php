<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\CreateReport;

use App\Reports\Domain\Factory\ReportFactory;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

readonly class CreateReportCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ReportFactory             $factory,
        private ReportRepositoryInterface $reportRepository,
    )
    {
    }

    public function __invoke(CreateReportCommand $command): CreateReportCommandResult
    {
        $report = $this->factory->create(
            $command->title,
            $command->template,
            $command->creatorId,
            $command->approverId,
            $command->variables
        );
        $this->reportRepository->save($report);

        return new CreateReportCommandResult(
            $report->getId()
        );
    }
}
