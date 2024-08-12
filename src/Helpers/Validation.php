<?php

namespace App\Helpers;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validation
{

    public function __construct(
        private readonly ValidatorInterface $validator,
    )
    {
    }

    public function validate($entity)
    {
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            $plainErrors = [];
            foreach ($errors as $error) {
                $plainErrors[] = $error->getMessage();
            }

            return $plainErrors;
        }

        return [];
    }

}