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
	 * @ORM\Column(type="double" name="valor")
	 */
	protected $valor;
	
	/**
	 * Refere-se a data incial da turma
	 * @ORM\Column(type="date" name="data_inicial")
	 */
	protected $inicial;
	
	/**
	 * Refere-se a data final da turma
	 * @ORM\Column(type="date" name="data_final")
	 */
	protected $final;
	
	/**
	 * @ORM\Column(type="string" name="instrutores")
	 */
	protected $instrutores;
	
	/**
	 * @ORM\Column(type="integer" name="capacitacao_id")
	 */
	protected $capacitacao;
	
	/**
	 * @ORM\Column(type="integer" name="instituicao_codigo")
	 */
	protected $instituicaoCodigo;
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
	public function getInicial() {
		return $this->inicial->format ( "d-m-Y" );
	}
	public function setInical($inicial) {
		$this->inicial = $inicial;
	}
	public function getFinal() {
		return $this->final->format ( "d-m-Y" );
	}
	public function setFinal($final) {
		$this->final = $final;
	}
	public function getInstrutores() {
		return $this->instrutores;
	}
	public function setInstrutores($instrutores) {
		$this->instrutores = $instrutores;
	}
	public function getICapacitacao() {
		return $this->capacitacao;
	}
	public function setCapacitacao($capacitacao) {
		$this->capacitacao = $capacitacao;
	}
	public function getInstituicaoCodigo() {
		return $this->instituicaoCodigo;
	}
	public function setValor($instituicaoCodigo) {
		$this->instituicaoCodigo = $instituicaoCodigo;
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
									'name' => 'Float',
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
					),
			)));
			
			$this->inputFilter = $inputFilter;
			}
		return $this->inputFilter;
		}
}