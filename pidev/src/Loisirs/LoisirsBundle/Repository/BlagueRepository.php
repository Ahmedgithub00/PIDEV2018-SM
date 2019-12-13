<?php

namespace Loisirs\LoisirsBundle\Repository;

/**
 * BlagueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlagueRepository extends \Doctrine\ORM\EntityRepository
{
    public function findBlague($p){
        $query=$this->getEntityManager()->createQuery(
            "select m from LoisirsLoisirsBundle:Blague m WHERE m.titre like :p"
        )->setParameter('p','%'.$p.'%');
        return $query->getResult();
    }

}
