<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\EventHandler;

use App\Reports\Domain\Aggregate\Report\ReportStatus;
use App\Reports\Domain\Event\ReportModificationCreatedEvent;
use App\Reports\Domain\Factory\ReportModificationFactory;
use App\Reports\Domain\Repository\ReportModificationRepositoryInterface;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Event\EventHandlerInterface;

class ReportModificationCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(
        private ReportRepositoryInterface             $repository,
        private ReportModificationRepositoryInterface $modificationRepository,
        private ReportModificationFactory             $modificationFactory,
    )
    {
    }

    public function __invoke(ReportModificationCreatedEvent $event): string
    {
        $report = $this->repository->findOneById($event->reportId);
        // если отчет утвержден, посылаю команду на создание файла отчета, но пока так для простоты
        if ($event->status === ReportStatus::APPROVED->value) {
            $report->setPath('/path-to-report/' . $report->getId() . '.pdf');
        }

        return 'test';
    }


}