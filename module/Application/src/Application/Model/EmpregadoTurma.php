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
	protected $empregado;
	
	/**
	 * @ORM\Column(type="integer" name="turma_id")
	 */
	protected $turma;
	public function getEmpregado() {
		return $this->empregado;
	}
	public function setEmpregado($empregado) {
		$this->empregado = $empregado;
	}
	public function getTurma() {
		return $this->turma;
	}
	public function setTurma($turma) {
		$this->turma = $turma;
	}
}