<?php

declare(strict_types=1);

namespace App\Reports\Application\DTO\Report;

class ReportDTO implements \JsonSerializable
{
    public ?string $id = null;
    public ?string $title = null;
    public ?string $template = null;
    public ?string $creator_id = null;
    public ?string $approver_id = null;
    public ?array $variables = null;
    public ?string $created_at = null;
    public ?string $path = null;
    public array $modifications = [];

    #[\Override] public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
