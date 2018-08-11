<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintTask extends Constraint
{
    public $message = 'Товар стоит менее 5$ и его колличество менее 10';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}