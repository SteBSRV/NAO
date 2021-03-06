<?php

namespace AppBundle\Repository;

/**
 * UserObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserObservationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findUserObservationFavorite($user_id, $observation_id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.observation = :observation_id')
            ->setParameter('observation_id', $observation_id)
            ->andWhere('u.user = :user_id')
            ->setParameter('user_id', $user_id)
            ->andWhere('u.favoriteObservation = true')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
