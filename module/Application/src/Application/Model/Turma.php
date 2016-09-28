<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entidade Turma
 *
 * @category Application
 * @package Model
 *
 *          @ORM\Entity
 *          @ORM\Table(name="turma")
 */
class Turma extends Entity {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
		
	/**
	 * @ORM\column(type="string", name="nome")
	 */
	protected $nome;
	
	/**
	 * @ORM\column(type="string", name="local")
	 */
	protected $local;
	
	/**
	 * @ORM\column(type="decimal", precision=2, name="valor")
	 */
	protected $valor;

	/**
	 * @ORM\column(type="string", name="forma")
	 */
	protected $forma;
	/**
	 * Refere-se a data incial da turma
	 * @ORM\Column(type="date", name="data_inicial")
	 */
	protected $inicial;

	/**
	 * Refere-se a data final da turma
	 * @ORM\Column(type="date", name="data_final")
	 */
	protected $final;

	/**
	 * @ORM\ManyToOne(targetEntity="Capacitacao")
	 * @ORM\JoinColumn(name="capacitacao_id", referencedColumnName="id")
	 */
	protected $capacitacao;

	/**
	 * @ORM\ManyToOne(targetEntity="Instituicao")
	 * @ORM\JoinColumn(name="instituicao_codigo", referencedColumnName="cod_instituicao")
	 */
	protected $instituicao;

	/**
	 * @ORM\ManyToMany(targetEntity="Empregado")
	 * @ORM\JoinTable(name="empregado_turma",
	 * joinColumns={@ORM\JoinColumn(name="turma_id", referencedColumnName="id")},
	 * inverseJoinColumns={@ORM\JoinColumn(name="empregado_matricula", referencedColumnName="cod_func")}
	 * )
	 */
	protected $participantes;

	/**
	 * @ORM\ManyToMany(targetEntity="Instrutor")
	 * @ORM\JoinTable(name="turma_instrutor",
	 * joinColumns={@ORM\JoinColumn(name="turma_id", referencedColumnName="id")},
	 * inverseJoinColumns={@ORM\JoinColumn(name="instrutor_id", referencedColumnName="id")}
	 * )
	 */
	protected $instrutores;
	public function __construct() {
		$this->participantes = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->instrutores = new \Doctrine\Common\Collections\ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getValor() {
		return $this->valor;
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
	public function getForma() {
		return $this->forma;
	}
	public function setForma($forma) {
		$this->forma = $forma;
	}
	public function getInicial() {
		return $this->inicial;
	}
	public function setInicial($inicial) {
		$this->inicial = $inicial;
	}
	public function getFinal() {
		return $this->final;
	}
	public function setFinal($final) {
		$this->final = $final;
	}
	public function getCapacitacao() {
		return $this->capacitacao;
	}
	public function setCapacitacao($capacitacao) {
		$this->capacitacao = $capacitacao;
	}
	public function getInstituicao() {
		return $this->instituicao;
	}
	public function setInstituicao($instituicao) {
		$this->instituicao = $instituicao;
	}
	public function getParticipantes() {
		return $this->participantes;
	}
	public function setParticipantes($participantes) {
		$this->participantes = $participantes;
	}
	public function getInstrutores() {
		return $this->instrutores;
	}
	public function setInstrutores($instrutores) {
		$this->instrutores = $instrutores;
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
				
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => false
			) ) );
				
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'valor',
					'required' => true,
					'validators' => array (
							array (
									// 'name' => 'Float',
									'options' => array (
											'min' => 2
									)
							)
					)
			) ) );
				
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'instrutores',
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
											'min' => 2,
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