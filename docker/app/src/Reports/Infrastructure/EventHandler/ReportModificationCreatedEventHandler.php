<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\EventHandler;

use App\Reports\Application\DTO\Report\ReportDTOTransformer;
use App\Reports\Domain\Aggregate\Report\ReportStatus;
use App\Reports\Domain\Event\ReportModificationCreatedEvent;
use App\Reports\Domain\Message\ExternalMessageToForward;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Event\EventHandlerInterface;
use App\Shared\Application\Message\MessageBusInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;

class ReportModificationCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(
        private ReportRepositoryInterface $repository,
        private ReportDTOTransformer      $reportDTOTransformer,
        private MessageBusInterface       $messageBus,

    )
    {
    }

    public function __invoke(ReportModificationCreatedEvent $event): string
    {
        // если отчет утвержден, посылаю команду на создание файла отчета, но пока так для простоты
        if ($event->status === ReportStatus::APPROVED->value) {
            $event->report->setPath('/path-to-report/' . $event->report->getId() . '.pdf');
        }
        $reportDto = $this->reportDTOTransformer->fromReportEntity($event->report);
        $message = new ExternalMessageToForward($event->report->getLastModification()->getStatus()->value, $reportDto->jsonSerialize());
        $envelope = new Envelope($message, [new AmqpStamp("#")]);

        $this->messageBus->execute($envelope);

        return 'test';
    }


}