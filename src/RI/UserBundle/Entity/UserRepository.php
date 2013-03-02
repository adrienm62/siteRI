<?php

namespace RI\UserBundle\Entity;
use Doctrine\ORM\EntityRepository;
class UserRepository extends EntityRepository {
    public function findDemandeSuppression(){
        $queryBuilder = $this->createQueryBuilder('u');
        
        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('u')
                ->from($this->_entityName, 'u')
                ->andWhere('u.demandeSuppression = 1');
        
        $query = $queryBuilder->getQuery();
        $resultats = $query->getResult();
        
        return $resultats;
    }
}

?>
