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
	 * @ORM\OneToOne(targetEntity="Capacitacao", inversedBy="listaEspera")
	 * @ORM\JoinColumn(name="capacitacao_id", referencedColumnName="id")
	 */
	protected $capacitacao;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Empregado")
	 * @ORM\JoinTable(name="empregado_lista",
	 * joinColumns={@ORM\JoinColumn(name="lista_id", referencedColumnName="id")},
	 * inverseJoinColumns={@ORM\JoinColumn(name="empregado_matricula", referencedColumnName="cod_func")}
	 * )
	 */
	protected $matricula;
	
	public function __construct() {
		$this->matricula = new \Doctrine\Common\Collections\ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getMatricula() {
		return $this->matricula;
	}
	public function setMatricula($matricula) {
		$this->matricula = $matricula;
	}
	public function getCapacitacao() {
		return $this->capacitacao;
	}
	public function setCapacitacao($capacitacao) {
		$this->capacitacao = $capacitacao;
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
	
	