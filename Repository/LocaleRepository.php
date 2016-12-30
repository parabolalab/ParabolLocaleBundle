<?php

namespace Parabol\LocaleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LocaleRepository extends EntityRepository
{
	
	public function validateRequired($criteria)
	{
		if($criteria['isDefault'])
		{
			$requiredLocale = $this->createQueryBuilder('l')
				->where('l.code != :code')
				->andWhere('l.isDefault = 1')
				->setParameter('code', $criteria['code'])
				->setMaxResults(1)
				->getQuery()
				->getOneOrNullResult()
				;

			return $requiredLocale;

			// var_dump($requiredLocale);
			// die();
		}
		else
		{
			return null;
		}
	}


	public function validateEnabled($criteria)
	{

		if(!$criteria['isEnabled'] && $criteria['isDefault'])
		{
			return new \Parabol\LocaleBundle\Entity\Locale();
		}
		else
		{
			return null;
		}
	}

}