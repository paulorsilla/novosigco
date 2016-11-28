<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

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
	 * @ORM\column(type="string", name="conteudo")
	 */
	protected $conteudos;
	
	/**
	 * @ORM\column(type="decimal", precision=2, name="valor")
	 */
	protected $valor;
	
	/**
	 * @ORM\column(type="string", name="aplicacao")
	 */
	protected $aplicacao;
	
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
	 * @ORM\ManyToOne(targetEntity="Instrutor")
	 * @ORM\JoinColumn(name="instrutor_id1", referencedColumnName="id")
	 */
	protected $instrutor1;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Instrutor")
	 * @ORM\JoinColumn(name="instrutor_id2", referencedColumnName="id")
	 */
	protected $instrutor2;
	
	/**
	 * @ORM\OneToOne(targetEntity="Empregado")
	 * @ORM\JoinColumn(name="coordenacao_tecnica", referencedColumnName="cod_func")
	 */
	protected $coordenacao;
	
	/**
	 * @ORM\OneToMany(targetEntity="TurmaProgramacao", mappedBy="turma")
	 */
	protected $programacao;
	public function __construct() {
		$this->programacao = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->participantes = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->instrutor1 = new \Doctrine\Common\Collections\ArrayCollection ();
		$this->instrutor2 = new \Doctrine\Common\Collections\ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getNome() {
		return $this->nome;
	}
	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function getValor() {
		return $this->valor;
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
	public function getAplicacao() {
		return $this->aplicacao;
	}
	public function setAplicacao($aplicacao) {
		$this->aplicacao = $aplicacao;
	}
	public function getCapacitacao() {
		return $this->capacitacao;
	}
	public function getConteudos() {
		return $this->conteudos;
	}
	public function setConteudos($conteudos) {
		$this->conteudos = $conteudos;
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
	public function getCoordenacao() {
		return $this->coordenacao;
	}
	public function setCoordenacao($coordenacao) {
		$this->coordenacao = $coordenacao;
	}
	public function getProgramacao() {
		return $this->programacao;
	}
	public function setProgramacao($programacao) {
		$this->programacao = $programacao;
	}
	public function getInstrutor1() {
		return $this->instrutor1;
	}
	public function setInstrutor1($instrutor1) {
		$this->instrutor1 = $instrutor1;
	}
	public function getInstrutor2() {
		return $this->instrutor2;
	}
	public function setInstrutor2($instrutor2) {
		$this->instrutor2 = $instrutor2;
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
					'name' => 'instrutor1',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) ) );
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'instrutor2',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim'
						)
				),
		)));
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'conteudos',
					'required' => false,
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
									)
							)
					)
			) ) );
		$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}