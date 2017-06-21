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
		if (!is_null($observationFilter['dateSince'])) {
			$dateSince = new \DateTime("-" . $observationFilter['dateSince'] . " days");
		} else {
			$dateSince;
		}
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

		if (isset($dateSince)) {
			$qb->andwhere('o.date >= :dateSince')
			   ->setParameter('dateSince', $dateSince)
			;
		}
		if (!is_null($popularity)) {

		}
		if (!is_null($nbr)) {
			$qb->andwhere('o.nbObserved >= :nbr')
			   ->setParameter('nbr', $nbr)
			;
		}
		if (!is_null($city)) {
			$qb->leftJoin('o.address', 'a')
			   ->andwhere('a.city = :city')
			   ->setParameter('city', $city)
			;
		}
		if (!is_null($region)) {
			if(is_null($city)) {
				$qb->leftJoin('o.address', 'a');
			}
			$qb->andwhere('a.region = :region')
			   ->setParameter('region', $region)
			;
		}

		return $qb->getQuery()->getResult();
	}
}
