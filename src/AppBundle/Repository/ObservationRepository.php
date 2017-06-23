<?php

namespace AppBundle\Repository;

/**
 * ObservationRepository
 *
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
	public function countValid() {
		return $this->createQueryBuilder('o')
			->select('count(o)')
			->where('o.state = 1')
			->getQuery()
			->getSingleScalarResult()
		;
	}
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
			$qb->andwhere('o.observeAt >= :dateSince')
			   ->setParameter('dateSince', $dateSince)
			;
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
		if (!is_null($popularity)) {
			if($popularity) {
				$qb->leftJoin('o.userObservation', 'uO')
			   	   ->andwhere('uO.favoriteObservation = :popularity')
			   	   ->setParameter('popularity', $popularity)
			   	   ->groupBy('uO.observation')
			   	   ->orderBy('uO.favoriteObservation')
				;
			} else {
				/*$qb->leftJoin('o.userObservation', 'uO')
				   ->andWhere('o.userObservation IS EMPTY')*/
				;
			}
		}
		$qb->andWhere('o.state = 1');

		return $qb->getQuery();
	}

	public function getUserObservations($user)
	{
		return $this->createQueryBuilder('o')
			->where("o.user = :user")
			->setParameter("user", $user)
			->getQuery()
			->getResult()
			;
	}

	public function getUserFavoriteObservations($id)
	{
		return $this->createQueryBuilder('o')
			->leftJoin('o.userObservation', 'uo')
			->addSelect('uo')
			->where('uo.user = :id')
			->andWhere('uo.favoriteObservation = true')
			->setParameter('id', $id)
			->getQuery()
			->getResult()
			;
	}


	public function getAllSubmittedObservations()
	{
		return $this->createQueryBuilder('o')
			->where("o.state = false")
			->getQuery()
			->getResult()
			;
	}

	public function getAllValidObservations()
	{
		return $this->createQueryBuilder('o')
			->where("o.state = true")
			->getQuery()
			->getResult()
			;
	}
}
