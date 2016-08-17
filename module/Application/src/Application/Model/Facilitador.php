<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Facilitador
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="facilitador")
 */
class Facilitador extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
// 	/**
// 	 * @ORM\Column(type="integer",name="cpf")
// 	 */
// 	protected $cpf;
	
	/**
	 * @ORM\Column(type="string",name="nome")
	 */
	protected $nome;
	
// 	/**
// 	 * @ORM\Column(type="date",name="data_nascimento")
// 	 */
// 	protected $nascimento;
	
	/**
	 * @ORM\Column(type="string",name="email")
	 */
	protected $email;
	
// 	/**
// 	 * @ORM\Column(type="string",name="telefone")
// 	 */
// 	protected $telefone;
	
	/**
	 * @ORM\Column(type="string",name="telefone_celular")
	 */
	protected $celular;
	
	/**
	 * @ORM\Column(type="text",name="curriculo")
	 */
	protected $curriculo;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Instituicao", inversedBy="facilitadores")
	 * @ORM\JoinColumn(name="instituicao_codigo", referencedColumnName="cod_instituicao")
	 */
	protected $instituicao;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
// 	public function getCpf() {
// 		return $this->cpf;
// 	}
// 	public function setCpf($cpf) {
// 		$this->cpf = $cpf;
// 	}
	public function getNome() {
		return $this->nome;
	}
	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
// 	public function getTelefone() {
// 		return $this->telefone;
// 	}
// 	public function setTelefone($telefone) {
// 		$this->telefone = $telefone;
// 	}
	public function getInstituicao() {
		return $this->instituicao;
	}
	public function setInstituicao($instituicao) {
		$this->instituicao = $instituicao;
	}
// 	public function getNascimento() {
// 		return $this->nascimento->format ( "d-m-Y" );
// 	}
// 	public function setNascimento($nascimento) {
// 		$this->nascimento = $nascimento;
// 	}
	public function getcelular() {
		return $this->celular;
	}
	public function setCelular($celular) {
		$this->celular = $celular;
	}
	public function getCurriculo() {
		return $this->curriculo;
	}
	public function setCurriculo($curriculo) {
		$this->curriculo = $curriculo;
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
			
// 			$inputFilter->add ( $factory->createInput ( array (
// 					'name' => 'cpf',
// 					'required' => true,
// 					'filters' => array (
// 							array (
// 									'name' => 'String' 
// 							) 
// 					) 
// 			) ) );
			
// 			$inputFilter->add ( $factory->createInput ( array (
// 					'name' => 'nascimento',
// 					'required' => true,
// 					'filters' => array (
// 							array (
// 									'name' => 'StripTags' 
// 							),
// 							array (
// 									'name' => 'StringTrim' 
// 							) 
// 					) 
// 			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'nome',
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