<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRegisterNaturaliste()
    {
        return $this->createQueryBuilder('u')
            ->where("u.accountType = 'naturaliste'")
            ->getQuery()
            ->getResult()
            ;
    }
}
