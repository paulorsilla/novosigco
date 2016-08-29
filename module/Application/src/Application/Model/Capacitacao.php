<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entidade Capacitacao
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="capacitacao")
 */
class Capacitacao extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="CapacitacaoTipo")
     * @ORM\JoinColumn(name="capacitacao_tipo_id", referencedColumnName="id")
	 */
	protected $capacitacaoTipo;
	
	/**
	 * @ORM\Column(type="string", name="descricao")
	 */
	protected $descricao;
	/**
	 * @ORM\ManyToMany(targetEntity="Competencia")
	 * @ORM\JoinTable(name="capacitacao_competencia",
	 * 		joinColumns={@ORM\JoinColumn(name="capacitacao_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="competencia_id", referencedColumnName="id")}
	 * )
	 */
	protected $competencias;

// 	/**
// 	 * @ORM\Column(type="integer", name="carga_horaria")
// 	 */
// 	protected $cargaHoraria;
	
	public function __construct(){
		$this->competencias = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getCapacitacaoTipo() {
		return $this->capacitacaoTipo;
	}
	public function setCapacitacaoTipo($capacitacaoTipo) {
		$this->capacitacaoTipo = $capacitacaoTipo;
	}
	public function getDescricao() {
		return $this->descricao;
	}
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
	public function getCompetencias() {
		return $this->competencias;
	}
	public function setCompetencias($competencias) {
		$this->competencias = $competencias;
	}
// 	public function getCargaHoraria() {
// 		return $this->cargaHoraria;
// 	}
// 	public function setCargaHoraria($cargaHoraria) {
// 		$this->cargaHoraria = $cargaHoraria;
// 	}
	
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => false
			) ) );
// 			$inputFilter->add ( $factory->createInput ( array (
// 					'name' => 'cargaHoraria',
// 					'required' => true
// 			) ) );
			
// 			$inputFilter->add ( $factory->createInput ( array (
// 					'name' => 'modalidadeCapacitacao',
// 					'required' => true,
// 					'filters' => array (
// 							array (
// 									'name' => 'StripTags' 
// 							),
// 							array (
// 									'name' => 'StringTrim' 
// 							) 
// 					),
// 					'validators' => array (
// 							array (
// 									'name' => 'StringLength',
// 									'options' => array (
// 											'encoding' => 'UTF-8',
// 											'min' => 5,
// 											'max' => 200 
// 									) 
// 							) 
// 					) 
// 			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'descricao',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 5,
											'max' => 200 
									) 
							) 
					) 
			) ) );
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
}