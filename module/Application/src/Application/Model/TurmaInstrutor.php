<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade TurmaInstrutor
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="turma_instrutor")
 *         
 */
class TurmaInstrutor extends Entity {
	
	/**
	 * @ORM\Column(type="integer" name="instrutor_id")
	 */
	protected $instrutor;
	
	/**
	 * @ORM\Column(type="integer" name="turma_id")
	 */
	protected $turma;
	public function getInstrutor() {
		return $this->instrutor;
	}
	public function setInstrutor($instrutor) {
		$this->instrutor = $instrutor;
	}
	public function getTurma() {
		return $this->turma;
	}
	public function setTurma($turma) {
		$this->turma = $turma;
	}
}