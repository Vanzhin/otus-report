<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\Repository;

use App\Reports\Domain\Aggregate\Report\ReportModification;
use App\Reports\Domain\Repository\ReportModificationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReportModificationRepository extends ServiceEntityRepository implements ReportModificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportModification::class);
    }

    #[\Override] public function save(ReportModification $modification): void
    {
        $this->getEntityManager()->persist($modification);
        $this->getEntityManager()->flush();
    }


    #[\Override] public function findPreviousByReportId(string $reportId): ?ReportModification
    {
        return $this->findOneBy(
            ['report' => $reportId], ['changedAt' => 'DESC']
        );

    }
}