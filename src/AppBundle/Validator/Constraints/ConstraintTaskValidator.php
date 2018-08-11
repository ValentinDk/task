<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintTaskValidator extends  ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        if (($object->getCostInUSA() < 5) && ($object->getStock() < 10)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}