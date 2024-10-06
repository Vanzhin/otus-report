<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\EventListener\Doctrine;

use App\Reports\Domain\Aggregate\Report\ReportModification;
use App\Reports\Domain\Aggregate\Report\Specification\ReportModificationSpecification;
use App\Reports\Domain\Aggregate\ReportModification\Specification\ReportSpecification;
use App\Shared\Domain\Specification\SpecificationInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

#[AsDoctrineListener(event: Events::postLoad)]
final readonly class InitSpecificationOnPostLoadListener
{
    // todo надо сделать один на все сущности, но ContainerBagInterface $container не видит спецификацию в параметрах
    public function __construct(private ContainerBagInterface $container, private ReportModificationSpecification $reportModificationSpecification)
    {
    }

    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof ReportModification) {
            $reflect = new \ReflectionClass($entity);

            foreach ($reflect->getProperties() as $property) {
                $type = $property->getType();

                if (is_null($type) || $property->isInitialized($entity)) {
                    continue;
                }

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                    // initialize specifications
                    $interfaces = class_implements($type->getName());
                    if (isset($interfaces[SpecificationInterface::class])) {
                        $property->setValue($entity, $this->reportModificationSpecification);
                    }
                }
            }
        }
    }
}
