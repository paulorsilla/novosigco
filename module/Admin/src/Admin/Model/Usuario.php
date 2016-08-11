<?php
namespace Admin\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade Usuario
*
* @category Admin
* @package Model
*
* @ORM\Entity
* @ORM\Table(name="usuario")
*/
class Usuario extends Entity
{
 
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="string", name="nome_completo")
	*/
	protected $nome;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $login;
	
	/**
	* @ORM\Column(type="string");
	*/
	protected $papel;
        
        /**
	* @ORM\Column(type="string")
	*/
	protected $email;

    /**
	* @ORM\Column(type="string")
	*/
	protected $ramal;
        
    
    public function getNome() 
    {
        return $this->nome;
    }
    
    public function setNome($nome) 
    {
    	$this->nome = $nome;
    }
    
    public function getLogin()
    {
    	return $this->login;
    }
    
    public function setLogin($login)
    {
    	$this->login = $login;
    }
    
    public function getPapel() 
    {
        return $this->papel;
    }
    
    public function setPapel($papel) 
    {
    	$this->papel = $papel;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email) 
    {
    	$this->email = $email;
    }
    
    public function getRamal()
    {
        return $this->ramal;
    }
    
    public function setRamal($ramal) 
    {
    	$this->ramal = $ramal;
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
				'name' => 'nome',
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
							'max' => 200,
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'login',
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
				'name' => 'papel',
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
							'max' => 20,
						),
					),
				),
			)));
                        
            $inputFilter->add($factory->createInput(array(
				'name' => 'email',
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
							'max' => 200,
						),
					),
				),
			)));

            $inputFilter->add($factory->createInput(array(
				'name' => 'ramal',
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
							'min' => 0,
							'max' => 10,
						),
					),
				),
			)));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
