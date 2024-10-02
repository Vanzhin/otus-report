<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

class ReportVariables implements \JsonSerializable
{
    private array $list;

    public function __construct(ReportVariable...$list)
    {
        foreach ($list as $variable) {
            $this->list[$variable->getName()] = $variable;
        }
    }

    public function getList(): array
    {
        return $this->list;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return $this->list;
    }
}