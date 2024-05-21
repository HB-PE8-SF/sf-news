<?php

namespace App\Validator;

use App\Mail\SpamChecker;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsNotSpamValidator extends ConstraintValidator
{
    public function __construct(
        private SpamChecker $spamChecker
    ) {
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var IsNotSpam $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->spamChecker->isSpam($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
