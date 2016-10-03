<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade EmpregadoTurma
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="empregado_turma")
 *         
 */
class EmpregadoTurma extends Entity {
	
	/**
	 * @ORM\Column(type="string" name="empregado_matricula")
	 */
	protected $matricula;
	
	/**
	 * @ORM\Column(type="integer" name="turma_id")
	 */
	protected $turma;
	public function getMatricula() {
		return $this->metricula;
	}
	public function setEmpregado($matricula) {
		$this->matricula = $matricula;
	}
	public function getTurma() {
		return $this->turma;
	}
	public function setTurma($turma) {
		$this->turma = $turma;
	}
}