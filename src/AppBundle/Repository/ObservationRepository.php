<?php

namespace AppBundle\Repository;

/**
 * ObservationRepository
 *
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
	public function search($observationFilter)
	{
		$bird = $observationFilter['bird'];
		$dateSince = $observationFilter['dateSince'];
		$region = $observationFilter['region'];
		$city = $observationFilter['city'];
		$popularity = $observationFilter['popularity'];
		$nbr = $observationFilter['nbObserved'];

		$qb = $this
			->createQueryBuilder('o')
			->leftJoin('o.bird', 'b')
			->where('b.nomVer = :bird')
			->setParameter('bird', $bird)
		;

		return $qb->getQuery()->getResult();
	}
}
