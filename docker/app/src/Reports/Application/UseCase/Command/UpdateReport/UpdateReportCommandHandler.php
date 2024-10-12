<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\UpdateReport;

use App\Reports\Application\Service\AccessController\ReportAccessControl;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Infrastructure\Exception\AppException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class UpdateReportCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportAccessControl       $accessControl,
    )
    {
    }

    public function __invoke(UpdateReportCommand $command): UpdateReportCommandResult
    {
        $report = $this->reportRepository->findOneById($command->reportId);
        if (!$report) {
            throw new AppException('No report found.');
        }
        if (!$this->accessControl->canAccess($command->userId, $report)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
        if (!$report->canBeEdited()) {
            throw new AppException('Report blocked for edit.');
        }
        if ($command->reportDTO->template) {
            $report->setTemplate($command->reportDTO->template);
        }
        if ($command->reportDTO->title) {
            $report->setTitle($command->reportDTO->title);
        }
        if ($command->reportDTO->variables) {
            $report->setVariables($command->reportDTO->variables);
        }
        $this->reportRepository->save($report);

        return new UpdateReportCommandResult(
            $report->getId(),
        );
    }
}
