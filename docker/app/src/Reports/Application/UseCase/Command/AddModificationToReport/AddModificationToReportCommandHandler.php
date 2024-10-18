<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Command\AddModificationToReport;

use App\Reports\Application\Service\AccessController\ReportAccessControl;
use App\Reports\Domain\Factory\ReportModificationFactory;
use App\Reports\Domain\Repository\ReportModificationRepositoryInterface;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Service\AssertService;
use App\Shared\Infrastructure\Exception\AppException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class AddModificationToReportCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ReportAccessControl                   $accessControl,
        private ReportRepositoryInterface             $reportRepository,
        private ReportModificationRepositoryInterface $modificationRepository,
        private ReportModificationFactory             $modificationFactory,
    )
    {
    }

    /**
     * @throws AppException
     */
    public function __invoke(AddModificationToReportCommand $command): AddModificationToReportCommandResult
    {
        $report = $this->reportRepository->findOneById($command->reportId);
        AssertService::notNull($report, 'No report found.');
        if (!$this->accessControl->canAccess($command->userId, $report)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
        $modification = $this->modificationFactory->create($report, $command->newStatus, $command->comment);
        $this->modificationRepository->save($modification);

        return new AddModificationToReportCommandResult();
    }
}
