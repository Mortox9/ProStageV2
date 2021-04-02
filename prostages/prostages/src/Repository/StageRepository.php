<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

     /**
      * @return Stage[] Returns an array of Stage objects
      */

    public function findByEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('stage')
            ->join('stage.entreprise','e')
            ->andWhere('e.nom = :entreprise')
            ->setParameter('entreprise', $nomEntreprise)
            ->orderBy('stage.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFormation($intituleFormation)
    {
      //Récupérer le gestionnaire d'entité
      $entityManager = $this->getEntityManager();

      //Construction de la requête
      $requete = $entityManager->createQuery(
        'SELECT stages FROM App\Entity\Stage stages
        JOIN stages.Formation formation
        WHERE formation.intitule = :intituleFormation'
      );
      $requete -> setParameter('intituleFormation', $intituleFormation);
      return $requete->execute();
    }

    public function findStageEtEntreprise()
    {

      $entityManager = $this->getEntityManager();

      $requete = $entityManager->createQuery(
        'SELECT stages.ent FROM App\Entity\Stage stages
        JOIN stages.entreprise ent
        ORDER BY sta.id ASC'
      );
      return $requete->execute();

    }


    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
