<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidTimezone extends Constraint
{
    public $message = 'The timezone "{{ timezone }}" is not valid.';
}