<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entidade Area
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="area")
 *         
 */
class Area extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Subarea", mappedBy="area")
	 */
	protected $subareas;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $descricao;
	public function __construct() {
		$this->subareas = new ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getDescricao() {
		return $this->descricao;
	}
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
	public function getSubareas() {
		return $this->subareas;
	}
	public function setSubareas($subareas) {
		$this->subareas = $subareas;
	}
	
	/**
	 * Configura os filtros dos campos da entidade
	 *
	 * @return Zend\InputFilter\InputFilter
	 */
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => false 
			) ) );
			
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
											'min' => 2,
							'max' => 200,
						),
					),
				),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
