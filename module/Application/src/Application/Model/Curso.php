<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entidade Curso
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="curso")
 */
class Curso extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="float", name="carga_horaria")
	 */
	protected $cargaHoraria;
	
// 	/**
// 	 * @ORM\Column(type="string", name="modalidade_capacitacao")
// 	 */
// 	protected $modalidadeCapacitacao;
	
	/**
	 * @ORM\ManyToOne(targetEntity="CursoTipo")
     * @ORM\JoinColumn(name="curso_tipo_id", referencedColumnName="id")
	 */
	protected $cursoTipo;
	
	/**
	 * @ORM\Column(type="string", name="descricao")
	 */
	protected $descricao;
	/**
	 * @ORM\ManyToMany(targetEntity="Competencia")
	 * @ORM\JoinTable(name="curso_competencia",
	 * 		joinColumns={@ORM\JoinColumn(name="curso_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="competencia_id", referencedColumnName="id")}
	 * )
	 */
	protected $competencias;
	
	public function __construct(){
		$this->competencias = new \Doctrine\Common\Collections\ArrayCollection();
	}	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getCargaHoraria() {
		return $this->cargaHoraria;
	}
	public function setCargaHoraria($cargaHoraria) {
		$this->cargaHoraria = $cargaHoraria;
	}
// 	public function getModalidadeCapacitacao() {
// 		return $this->modalidadeCapacitacao;
// 	}
// 	public function setModalidadeCapacitacao($modalidadeCapacitacao) {
// 		$this->modalidadeCapacitacao = $modalidadeCapacitacao;
// 	}
	public function getDescricao() {
		return $this->descricao;
	}
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
	public function getCursoTipo() {
		return $this->cursoTipo;
	}
	public function setCursoTipo($cursoTipo) {
		$this->cursoTipo = $cursoTipo;
	}
	public function getCompetencias() {
		return $this->competencias;
	}
	public function setCompetencias($competencias) {
		$this->competencias = $competencias;
	}
		public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) ) );
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'cargaHoraria',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) ) );
			
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