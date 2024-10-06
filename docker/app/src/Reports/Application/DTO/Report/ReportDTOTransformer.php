<?php

declare(strict_types=1);

namespace App\Reports\Application\DTO\Report;


use App\Reports\Application\DTO\ReportModification\ReportModificationDTOTransformer;
use App\Reports\Domain\Aggregate\Report\Report;

class ReportDTOTransformer
{
    public function __construct(private ReportModificationDTOTransformer $transformer)
    {
    }

    public function fromReportEntity(Report $report): ReportDTO
    {
        $dto = new ReportDTO();
        $dto->id = $report->getId();
        $dto->title = $report->getTitle();
        $dto->template = $report->getTemplate();
        $dto->creator_id = $report->getCreatorId();
        $dto->approver_id = $report->getApproverId();
        $dto->variables = $report->getVariables();
        $dto->created_at = $report->getCreatedAt()->format(DATE_ATOM);
        $dto->path = $report->getPath();
        $dto->modifications = $this->transformer->fromReportModificationList($report->getModifications());

        return $dto;
    }

    public function fromArray(array $data): ReportDTO
    {
        $dto = new ReportDTO();
        $dto->title = $data['title'];
        $dto->template = $data['template'];
        $dto->variables = $data['variables'];

        return $dto;
    }

    public function fromReportEntityList(iterable $entities): array
    {
        $reports = [];
        foreach ($entities as $entity) {
            $reports[] = $this->fromReportEntity($entity);
        }

        return $reports;
    }
}
