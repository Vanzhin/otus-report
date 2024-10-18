<?php

declare(strict_types=1);

namespace App\Reports\Application\DTO\ReportModification;

use App\Reports\Domain\Aggregate\Report\ReportModification;

class ReportModificationDTOTransformer
{
    public function fromReportModificationEntity(ReportModification $modification): ReportModificationDTO
    {
        $dto = new ReportModificationDTO();
        $dto->status = $modification->getStatus()->value;
        $dto->changed_at = $modification->getChangedAt()->format(DATE_ATOM);
        $dto->comment = $modification->getComment();

        return $dto;
    }

    public function fromReportModificationList(iterable $entities): array
    {
        $reportsModifications = [];
        foreach ($entities as $entity) {
            $reportsModifications[] = $this->fromReportModificationEntity($entity);
        }

        return $reportsModifications;
    }
}
