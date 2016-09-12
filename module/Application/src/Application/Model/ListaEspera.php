<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Lista de Espera
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="lista_espera")
 */
class ListaEspera extends Entity {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="capacitacao")
	 * @ORM\JoinColumn(name="capacitacao_id", referencedColumnName="id")
	 */
	protected $capacitacao;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Empregado")
	 * @ORM\JoinTable(name="empregado_lista",
	 * joinColumns={@JoinColumn(name="empregado_matricula", referencedColumnName="matricula")},
	 * inverseJoinColumns={@JoinColumn(name="lista_id", referencedColumnName="id")}
	 * )
	 */
	protected $matricula;
	
	/**
	 * Refere-se a data de inclusão
	 * @ORM\Column(type="date" name="data_inclusao")
	 */
	protected $inclusao;
	
	/**
	 * @ORM\Column(type="integer" name="prioridade")
	 */
	protected $prioridade;
	public function getMatricula() {
		return $this->matricula;
	}
	public function setMatricula($matricula) {
		$this->matricula = $matricula;
	}
	public function __construct() {
		$this->matricula = new \Doctrine\Common\Collections\ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getCurso() {
		return $this->curso;
	}
	public function setCurso($curso) {
		$this->curso = $curso;
	}
	public function getInclusao() {
		return $this->inclusao->format ( "d-m-Y" );
	}
	public function setInclusao($inclusao) {
		$this->inclusao = $inclusao;
	}
	public function getPrioridade() {
		return $this->prioridade;
	}
	public function setPrioridade($prioridade) {
		$this->prioridade = $prioridade;
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => false 
			) ) );
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
	
	