<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Modadelidade
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="modalidade")
 *         
 */
class Modalidade extends Entity {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", name="titulo")
	 */
	protected $titulo;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getTitulo() {
		return $this->titulo;
	}
	public function setDescricao($titulo) {
		$this->descricao = $titulo;
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
					'name' => 'titulo',
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