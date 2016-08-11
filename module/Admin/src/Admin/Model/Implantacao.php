<?php
namespace Admin\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade Implantação
*
* @category Admin
* @package Model
*
* @ORM\Entity
* @ORM\Table(name="implantacao")
*/
class Implantacao extends Entity
{
 
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* 
	*/
	protected $instituicao;
    
	
	public function getInstituicao() {
		return $this->instituicao;
	}
	
	public function setInstituicao($instituicao) {
		$this->instituicao = $instituicao;
	}
}
