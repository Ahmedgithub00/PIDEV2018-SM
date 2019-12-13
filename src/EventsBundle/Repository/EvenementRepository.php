<?php

namespace EventsBundle\Repository;

use Symfony\Component\Validator\Constraints\DateTime;

/**
 * EvenementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvenementRepository extends \Doctrine\ORM\EntityRepository
{


    function findSerieDQL($nom)
    {
        $query = $this->getEntityManager()
            ->createQuery("select v from EventsBundle:Evenement v WHERE v.nom 
LIKE :nom ")
            ->setParameter('nom', '%' . $nom . '%');
        return $query->getResult();


    }


    public function findbest()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM EventsBundle:Evenement p WHERE strtodate(p.datedeb, '%d-%m-%Y %h:%i')>= CURRENT_DATE() order by   p.particiate  DESC ");
        return $query->getResult();
    }

    public function finddql()
    {


        $date = new \DateTime();
        $query = $this->getEntityManager()->createQuery("SELECT p FROM EventsBundle:Evenement p ORDER BY p.datedeb ASC"
        );

        return $query->getResult();
    }


    public function findNom($nom)
    {
        $q = $this->createQueryBuilder('m')
            ->where('m.nom LIKE :nom')

            ->setParameter(':nom', "%$nom%");
        return $q->getQuery()->getResult();
    }


    public function findAjax($search)
    {/*$date_from = new \DateTime('now');
        ->setParameter('date_from', $date_from)
        ->andWhere('e.datedeb > = :date_form')*/

        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :nom')
            ->orWhere('e.nomorg LIKE :nom')
            ->orWhere('e.datedeb LIKE :nom')
            ->setParameter('nom','%' .$search . '%')
            ->getQuery()
            ->getResult();
    }
//fel Controller


}
