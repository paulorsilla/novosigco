<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class InstituicaoRepository extends EntityRepository {
	public function getInstituicoes() {
		$qb = $this->createQueryBuilder ( 'i' );
		$query = $qb->select('i')
		// 					->groupBy('i.razao')
// 		->where('i.tipoPessoa = :tipoPessoa')
// 		->andWhere($qb->expr()
// 				->neq('i.razao','?2'))
// 				->OrderBy('i.razao','ASC')
// 				->setParameter('tipoPessoa', 'Pessoa Jurídica')
// 				->setParameter(2, '')
				->getQuery ();
		return $query->getResult();
	}
}