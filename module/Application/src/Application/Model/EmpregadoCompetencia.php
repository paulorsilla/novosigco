<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade EmpregadoCompetencia
* @category Application
* @package Model
*
* @ORM\Entity
* @ORM\Table(name="empregado_competencia")
*/

class EmpregadoCompetencia extends Entity{

	/**
	 * @ORM\id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 **/
	protected $id;
	
	/**
	* @ORM\Column(type="date', name="data_aquisicao")
	**/
	
	protected $dataAquisicao;
	
	/**
	 * @ORM\Column(type="integer", name="escala")
	 */
	
	protected $escala;
	
	/**
	 * @ORM\Column(type="boolean", name="validacao")
	 */
	
	protected $validacao;
	
	/**
	 * @ORM\Column(type="boolean", name="acao_corporativa")
	 */
	
	protected $acaoCorporativa;
	
	public function getId() {
	return $this->id;
}
	public function setId($id){
		$this->id = $id;
	}
	public function getDataAquisicao(){
		return $this->dataAquisicao;
	}
	public function setDataAquisicao($dataAquisicao){
		$this->dataAquisicao = $dataAquisicao;
	}
	public function getEscala(){
		return $this->escala;
	}
	public function setEscala($escala){
		$this->dataAquisicao = $dataAquisicao;
	}
	public function getValidacao(){
		return $this->validacao;
	}
	public function setValidacao($validacao){
		$this->validacao = $validacao;
	}
}