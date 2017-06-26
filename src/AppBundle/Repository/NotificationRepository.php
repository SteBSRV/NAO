<?php

namespace AppBundle\Repository;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserNotifications($user)
    {
        return $this->createQueryBuilder('n')
            ->where("n.user = :user")
            ->setParameter('user', $user)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}