<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\EventHandler;

use App\Reports\Application\UseCase\Command\AddModificationToReport\AddModificationToReportCommand;
use App\Reports\Domain\Aggregate\Report\ReportStatus;
use App\Reports\Domain\Event\ReportCreatedEvent;
use App\Reports\Domain\Factory\ReportModificationFactory;
use App\Reports\Domain\Repository\ReportModificationRepositoryInterface;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Event\EventHandlerInterface;

class ReportCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(
        private ReportRepositoryInterface $repository,
        private ReportModificationRepositoryInterface $modificationRepository,
        private ReportModificationFactory $modificationFactory,
    )
    {
    }

    public function __invoke(ReportCreatedEvent $event): string
    {
        return 'test';
        // при создании отчета, создается первая модификация
//        $report = $this->repository->findOneById($event->reportId);
//        $command = new AddModificationToReportCommand(
//            $event->userId,
//            $event->reportId,
//            $event->status
//        );
//        $modification = $this->modificationFactory->create($report, ReportStatus::CREATED->value);
//        $this->modificationRepository->save($modification);
        //$this->logger->error('ReportCreatedEventHandler!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
        //        // при создании отчета, создается первая модификация
        //        try {
        //            $command = new AddModificationToReportCommand(
        //                $event->userId,
        //                $event->reportId,
        //                $event->status
        //            );
        //            $this->commandBus->execute($command);
        //        }catch (Exception| \Error $e){
        //            var_dump($e->getMessage());
        //        }
    }


}