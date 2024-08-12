<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly SerializerInterface $serializer)
    {
        parent::__construct($registry, Post::class);
    }

    public function normalizePost( Post $post )
    {

        $data = $this->serializer->normalize( $post, null, ["groups" => "post_details"] );

        $userInfo = $post->getUser();
        $data["author"] = [
            "id" => $userInfo->getId(),
            "username" => $userInfo->getUsername(),
            "email" => $userInfo->getEmail(),
        ];

        return $data;
    }

    
    public function getAllPost(): array
    {
        return $this->findAll();
    }

    public function getByID( int $id ): ?Post
    {
        return $this->find($id);
    }
    
    
    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
