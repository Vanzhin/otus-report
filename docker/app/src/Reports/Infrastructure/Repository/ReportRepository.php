<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\Repository;

use App\Reports\Domain\Aggregate\Report\Report;
use App\Reports\Domain\Repository\ReportRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReportRepository extends ServiceEntityRepository implements ReportRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    #[\Override] public function save(Report $report): void
    {
        $this->getEntityManager()->persist($report);
        $this->getEntityManager()->flush();
    }

}