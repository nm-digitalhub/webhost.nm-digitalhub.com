<?php

declare(strict_types=1);

namespace Laravel\Jetstream\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Laravel\Jetstream\Jetstream;

class Role implements ValidationRule
{
    public function __construct(
        private readonly Jetstream $jetstream
    ) {}

    /**
     * Determine if the validation rule passes.
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! in_array($value, array_keys($this->jetstream->getRoles()))) {
            $fail(__('The :attribute must be a valid role.'));
        }
    }
}
