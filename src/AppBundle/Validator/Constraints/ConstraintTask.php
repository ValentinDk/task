<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintTask extends Constraint
{
    public $massage = "Error";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}