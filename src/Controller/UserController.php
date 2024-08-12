<?php

namespace App\Controller;

use App\Helpers\APIResponse;
use App\Repository\UserInfoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/user", name: "user_")]
class UserController extends AbstractController
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * Questa rotta non contiene l'id dell'utente perché un utente loggato può solo modificare le proprie informazioni
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("", name: "updateInfo", methods: ["PATCH"])]
    public function updateUserInfo( Request $request ): JsonResponse
    {

        $currentUser = $this->getUser();
        $userInfo = $currentUser->getUserInfo();

        $userInfoAr = [
            "telephone" => $request->get("telephone") ?? $userInfo->getTelephone(),
            "bio" => $request->get("bio") ?? $userInfo->getBio(),
            "profileImgPath" => $request->get("profileImgPath") ?? $userInfo->getProfileImgPath(),
            "birthDate" => new \DateTime( $request->get("birthDate") ) ?? $userInfo->getBirthDate(),
        ];

        $userInfo->setTelephone( $userInfoAr["telephone"] );
        $userInfo->setBio( $userInfoAr["bio"] );
        $userInfo->setProfileImgPath( $userInfoAr["profileImgPath"] );
        $userInfo->setBirthDate( $userInfoAr["birthDate"] );

        $this->entityManager->persist( $userInfo );
        $this->entityManager->flush();

        return APIResponse::returnSuccess( data: $this->userRepository->normalizeUser( $currentUser) );
    }

}
