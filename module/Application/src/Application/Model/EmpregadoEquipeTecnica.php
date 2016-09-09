<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade EmpregadoEquipeTecnica
 * 
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="empregado_equipe_tecnica")
 *         
 */
class EmpregadoEquipeTecnica extends Entity {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", name="empregado_matricula");
	 */
	protected $empregado;
	
	/**
	 * @ORM\ManyToOne(targetEntity="EquipeTecnica")
	 * @ORM\JoinColumn(name="equipe_tecnica_id", referencedColumnName="id")
	 */
	protected $equipeTecnica;
	
	/**
	 * @ORM\Column(type="string", name="data_inicial")
	 */
	protected $dataInicial;
	
	/**
	 * @ORM\Column(type="string", name="data_final")
	 */
	protected $dataFinal;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getEmpregado() {
		return $this->empregado;
	}
	public function setEmpregado($empregado) {
		$this->empregado = $empregado;
	}
	public function getEquipeTecnica() {
		return $this->equipeTecnica;
	}
	public function setEquipeTecnica($equipeTecnica) {
		$this->equipeTecnica = $equipeTecnica;
	}
	public function getDataInicial() {
		return $this->dataInicial;
	}
	public function setDataInicial($dataInicial) {
		$this->dataInicial = $dataInicial;
	}
	public function getDataFinal() {
		return $this->dataFinal;
	}
	public function setDataFinal($dataFinal) {
		$this->dataFinal = $dataFinal;
	}
}
