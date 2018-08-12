<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintTaskValidator extends  ConstraintValidator
{
    const COST = 5;
    const STOCK = 10;

    /**
     * @param mixed $object
     * @param Constraint $constraint
     */
    public function validate($object, Constraint $constraint):void
    {
        if (($object->getCostInUSA() < self::COST) && ($object->getStock() < self::STOCK)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}