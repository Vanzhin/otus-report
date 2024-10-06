<?php

declare(strict_types=1);

namespace App\Reports\Application\UseCase\Query\FindReport;

use App\Reports\Application\DTO\Report\ReportDTOTransformer;
use App\Reports\Application\Service\AccessController\ReportAccessControl;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class FindReportQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportDTOTransformer      $reportDTOTransformer,
        private ReportAccessControl       $accessControl,
    )
    {
    }

    public function __invoke(FindReportQuery $query): FindReportQueryResult
    {
        $report = $this->reportRepository->findOneById($query->reportId);
        if (!$report) {
            return new FindReportQueryResult(null);
        }
        if (!$this->accessControl->canAccess($query->userId, $report)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
        $reportDTO = $this->reportDTOTransformer->fromReportEntity($report);

        return new FindReportQueryResult($reportDTO);
    }
}
