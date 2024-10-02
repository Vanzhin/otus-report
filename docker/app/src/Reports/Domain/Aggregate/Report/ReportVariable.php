<?php
declare(strict_types=1);


namespace App\Reports\Domain\Aggregate\Report;

class ReportVariable implements \JsonSerializable
{
    public function __construct(private string $name, private string $value)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[\Override] public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}