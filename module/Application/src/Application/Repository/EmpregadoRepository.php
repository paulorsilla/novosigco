<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class EmpregadoRepository extends EntityRepository {
	public function getEmpregados() {
		$qb = $this->createQueryBuilder ( 'e' );
		return $qb->select ( 'e' )
					->where ( 'e.matricula < 500000' )
					->andWhere ( 'e.ativo = :ativo' )
					->setParameter ( "ativo", "S" )
					->orderby ( 'e.nome' )
					->getQuery ()
					->getResult ();
	}
}
