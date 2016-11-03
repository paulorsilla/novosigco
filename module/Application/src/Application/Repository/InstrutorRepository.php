<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class InstrutorRepository extends EntityRepository {
	public function getInstrutores() {
		$qb = $this->createQueryBuilder ( 'i' );
		return $qb->select ( 'i' )
		->orderby ( 'i.nome' )
		->getQuery ()
		->getResult ();
	}
}
