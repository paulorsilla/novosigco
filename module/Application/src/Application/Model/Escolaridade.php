<?php
namespace Application\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade Escolaridade
*
* @category Application
* @package Model
*
* @ORM\Entity
* @ORM\Table(name="escolaridade")
*/
class Escolaridade extends Entity
{
 
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
	 * @ORM\Column(type="integer")
	 */
	protected $ordem;
	
	
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

	public function getOrdem() {
		return $this->ordem;
	}
	
	public function setOrdem($ordem) {
		$this->ordem = $ordem;
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
							'min' => 2,
							'max' => 200,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
					'name' => 'ordem',
					'required' => true,
					'filters' => array(
							array('name' => 'Int'),
					),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}

}
