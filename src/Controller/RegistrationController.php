<?php

namespace App\Controller;

use App\Entity\User;
use App\Helpers\APIResponse;
use App\Helpers\Validation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly Validation $validation
    )
    {
    }


    #[Route( "/api/registration", name: "registration", methods: ["POST" ] )]
    public function index( Request $request): JsonResponse
    {

        $plainTextPassword = $request->request->get( "password" );
        $username = $request->request->get( "username" );
        $email = $request->request->get( "email" );

        if( $plainTextPassword === null ) {
            return APIResponse::returnError( message: "The password field is required" );
        }


        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setUsername( $username );
        $user->setEmail( $email );

        $hashedPassword = $this->passwordHasher->hashPassword( $user, $plainTextPassword );
        $user->setPassword( $hashedPassword );

        $errors = $this->validation->validate( $user );
        if( !empty( $errors ) ) {
            return APIResponse::returnError( message: $errors );
        }

        $this->entityManager->persist( $user );
        $this->entityManager->flush();

        return APIResponse::returnSuccess(
            code: 201
        );
    }

}
