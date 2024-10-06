<?php
declare(strict_types=1);


namespace App\Reports\Domain\Validation;

use App\Reports\Domain\Validation\VO\Error;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ValidatorBuilder;

readonly class Validator
{
    public function __construct(
        private ValidatorBuilder $validatorBuilder,
    )
    {
    }

    /**
     * @return Error[]
     */
    public function validate(array $request, Collection $constraint): array
    {
        $violations = $this->validatorBuilder->getValidator()->validate($request, $constraint);

        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = new Error($violation->getPropertyPath(), $violation->getMessage());
        }

        return $errors;
    }
}