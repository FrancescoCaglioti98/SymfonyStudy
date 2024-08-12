<?php

namespace App\Controller;

use App\Entity\Post;
use App\Helpers\APIResponse;
use App\Helpers\Validation;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/posts", name: "post_")]
class PostController extends AbstractController
{


    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PostRepository $postRepository,
        private readonly Validation $validation,
        private readonly Security $security
    )
    {
    }


    #[Route('', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->getAllPost();

        $returnData = [];
        foreach ($posts as $post) {
            $returnData[] = $this->postRepository->normalizePost( $post );
        }

        return APIResponse::returnSuccess( data: $returnData );
    }


    #[Route('/{id}', name: 'get_id', methods: ['GET'])]
    public function getByID( int $id ): JsonResponse
    {
        $post = $this->postRepository->getById( $id );
        if( $post === null ) {
            return APIResponse::returnError(
                code: 404,
                message: "Post not found"
            );
        }

        return APIResponse::returnSuccess( data: $this->postRepository->normalizePost( $post ) );
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function createPost( Request $request ): JsonResponse
    {

        $post = new Post();

        $post->setTitle( $request->request->get('title') );
        $post->setContent( $request->request->get('content') );
        $post->setUser( $this->security->getUser() );
        $post->setCreationDate( new \DateTime() );
        $post->setModifiedDate( new \DateTime() );

        $errors = $this->validation->validate( $post );
        if( !empty( $errors ) ) {
            return APIResponse::returnError( message: $errors );
        }


        $this->entityManager->persist( $post );
        $this->entityManager->flush();

        return APIResponse::returnSuccess( code: 201 );
    }

}
