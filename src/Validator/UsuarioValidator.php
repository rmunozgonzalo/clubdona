<?php

namespace App\Validator;

use App\Entity\Usuario;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class UsuarioValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($entity, Constraint $constraint)
    {
        if (get_class($entity) != Usuario::class) {
            return;
        }

    }
}
