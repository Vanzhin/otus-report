<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report\VO;

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

    public function setVariable(ReportVariable $variable): void
    {
        $this->list[$variable->getName()] = $variable;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return array_values($this->list);
    }
}