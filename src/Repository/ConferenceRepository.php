<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Conference::class);
    }

    // /**
    //  * @return Conference[] Returns an array of Conference objects
    //  */

    public function getAvaiableDates($page) {

        $page--;
        $page = $page * 2;

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT DATE_FORMAT(p.date, "%Y-%m-%d") as date
        FROM conference p        
        GROUP BY DATE_FORMAT(p.date, \'%Y-%m-%d\')
        ORDER BY DATE_FORMAT(p.date, \'%Y-%m-%d\') DESC     
        LIMIT 2
        OFFSET              
        ' . $page;


        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    
    
    public function getConferenceForADay($date) {
        

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *, DATE_FORMAT(p.date, \'%W %M %e %Y\') as btDate, DATE_FORMAT(p.date, \'%H:%i\') as timeDate 
        FROM conference p        
        WHERE DATE_FORMAT(p.date, \'%Y-%m-%d\') = \''.$date.'\'        
        ';


        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    
      public function rechercheConf(string $recherche){
        return $this->createQueryBuilder('c')
        ->where('c.title LIKE :title')
                ->setParameter('title','%'.$recherche.'%')
                ->getQuery()
                ->getResult();
    }
    

    /*
      public function findOneBySomeField($value): ?Conference
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
    
  
    
    
}
