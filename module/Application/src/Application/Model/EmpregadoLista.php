<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Empregado Lista de Espera
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="empregado_lista")
 */
class EmpregadoLista extends Entity {
	/**
	 * @ORM\Column(type="integer" name="lista_id")
	 */
	protected $lista;
	
	/**
	 * @ORM\Column(type="string" name="empregado_matricula")
	 */
	protected $matricula;
	public function getLista() {
		return $this->lista;
	}
	public function setLista($lista) {
		$this->lista = $lista;
	}
	public function getMatricula() {
		return $this->matricula;
	}
	public function setMatricula($matricula) {
		$this->matricula = $matricula;
	}
}
