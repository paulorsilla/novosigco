<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entidade Turma Programacao
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="turma_programacao")
 */

class TurmaProgramacao extends Entity {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="date", name="data_realizacao")
	 */	
	protected $dataRealizacao;
	
	/**
	 * @ORM\Column(type="string", name="hora_inicial")
	 */
	protected $horaInicial;
	
	/**
	 *@ORM\Column(type=string", name="hora_final") 
	 */
	protected $horaFinal;
	
	/**
	 * @ORM\Column(type="string", name="local")
	 */
	protected $local;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getDataRealizacao() {
		return $this->dataRealizacao;
	}
	public function setDataRealizacao($dataRealizacao) {
		$this->dataRealizacao = $dataRealizacao;
	}
	public function getHoraInicial() {
		return $this->horaInicial;
	}
	public function setHoraInicial($horaInicial) {
		$this->horaInicial = $horaInicial;
	}
	public function getHoraFinal() {
		return $this->horaFinal;
	}
	public function setHoraFinal($horaFinal) {
		$this->horaFinal = $horaFinal;
	}
	public function getLocal() {
		return $this->local;
	}
	public function setLocal($local) {
		$this->local = $local;
	}
	
	
	
	
	
}