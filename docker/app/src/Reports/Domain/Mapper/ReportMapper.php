<?php
declare(strict_types=1);


namespace App\Reports\Domain\Mapper;

use Symfony\Component\Validator\Constraints as Assert;

class ReportMapper
{
    public function getValidationCollectionReport(): Assert\Collection
    {
        return new Assert\Collection([
            'title' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'template' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'creator_id' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'approver_id' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
            'variables' => new Assert\Optional(
                new Assert\All([
                    new Assert\Collection([
                        'name' => [
                            new Assert\NotBlank(),
                            new Assert\Type('string'),
                        ],
                        'value' => [
                            new Assert\NotBlank(),
                            new Assert\Type('string'),
                        ],
                    ])
                ]),
            )
        ]);
    }

}