<?php

namespace App\Controller;

use App\Entity\User;
use App\Helpers\APIResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
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

        $errors = $this->validator->validate($user);
        if( count($errors) > 0 ) {

            $plainErrors = [];
            foreach ( $errors as $error ) {
                $plainErrors[] = $error->getMessage();
            }

            return APIResponse::returnError( message: $plainErrors );
        }

        $this->entityManager->persist( $user );
        $this->entityManager->flush();

        return new JsonResponse(
            data: [],
            status: 201
        );
    }

}
