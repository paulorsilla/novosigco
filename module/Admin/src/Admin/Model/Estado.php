<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Estado
 *
 * @category Admin
 * @package Model
 * @author Paulo R. Silla - paulo.silla@embrapa.br
 * 
 * @ORM\Entity
 * @ORM\Table(name="estado")
 */
class Estado extends Entity {
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $descricao;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $sigla;
	
    public function getDescricao() 
    {
        return $this->descricao;
    }
    
    public function getSigla() 
    {
        return $this->sigla;
    }
    
	/**
	* Configura os filtros dos campos da entidade
	*
	* @return Zend\InputFilter\InputFilter
	*/
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
		
			$inputFilter->add($factory->createInput(array(
				'name' => 'id',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'descricao',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 50,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'sigla',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 2,
							'max' => 2,
						),
					),
				),
            )));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
